<?php

/**
 * Take from https://github.com/caseyamcl/guzzle_retry_middleware/edit/master/src/GuzzleRetryMiddleware.php
 */

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Middleware;

use Closure;
use DateTime;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class RetryMiddleware
{
    public const DATE_FORMAT = 'D, d M Y H:i:s T';
    public const RETRY_HEADER = 'X-Retry-Counter';
    public const RETRY_AFTER_HEADER = 'Retry-After';

    private array $defaultOptions = [
        'retry_enabled' => true,
        // If server doesn't provide a Retry-After header, then set a default back-off delay
        // NOTE: This can either be a float, or it can be a callable that returns a (accepts count and response|null)
        'default_retry_multiplier' => 1.5,
        'max_retry_attempts' => 3,
        'max_allowable_timeout_secs' => null,
        // Set this to TRUE to retry only if the HTTP Retry-After header is specified
        'retry_only_if_retry_after_header' => false,
        'retry_on_status' => ['429', '503'],
        // Callback to trigger before delay occurs (accepts count, delay, request, response, options)
        'on_retry_callback' => null,
        'retry_on_timeout' => false,
        'expose_retry_header' => false,
        'retry_header' => self::RETRY_HEADER,
        'retry_after_header' => self::RETRY_AFTER_HEADER,
        'retry_after_date_format' => self::DATE_FORMAT
    ];

    /**
     * @var callable
     */
    private $nextHandler;

    public static function factory(array $defaultOptions = []): Closure
    {
        return static function (callable $handler) use ($defaultOptions): self {
            return new self($handler, $defaultOptions);
        };
    }

    public function __construct(callable $nextHandler, array $defaultOptions = [])
    {
        $this->nextHandler = $nextHandler;
        $this->defaultOptions = array_replace($this->defaultOptions, $defaultOptions);
    }

    public function __invoke(RequestInterface $request, array $options): Promise
    {
        $options = array_replace($this->defaultOptions, $options);

        if (!isset($options['retry_count'])) {
            $options['retry_count'] = 0;
        }

        $next = $this->nextHandler;
        return $next($request, $options)
            ->then(
                $this->onFulfilled($request, $options),
                $this->onRejected($request, $options)
            );
    }

    private function onFulfilled(RequestInterface $request, array $options): callable
    {
        return function (ResponseInterface $response) use ($request, $options) {
            return $this->shouldRetryHttpResponse($options, $response)
                ? $this->doRetry($request, $options, $response)
                : $this->returnResponse($options, $response);
        };
    }

    private function onRejected(RequestInterface $request, array $options): callable
    {
        return function ($reason) use ($request, $options): PromiseInterface {
            if ($reason instanceof BadResponseException) {
                if ($this->shouldRetryHttpResponse($options, $reason->getResponse())) {
                    return $this->doRetry($request, $options, $reason->getResponse());
                }
            } elseif ($reason instanceof ConnectException) {
                if ($this->shouldRetryConnectException($options)) {
                    return $this->doRetry($request, $options);
                }
            }

            return Create::rejectionFor($reason);
        };
    }

    private function shouldRetryConnectException(array $options): bool
    {
        return $options['retry_enabled']
            && ($options['retry_on_timeout'] ?? false)
            && $this->countRemainingRetries($options) > 0;
    }

    private function shouldRetryHttpResponse(array $options, ?ResponseInterface $response = null): bool
    {
        $statuses = array_map('\intval', (array) $options['retry_on_status']);
        $hasRetryAfterHeader = $response && $response->hasHeader('Retry-After');

        switch (true) {
            case $options['retry_enabled'] === false:
            case $this->countRemainingRetries($options) === 0: // No Retry-After header, and it is required?  Give up
            case (!$hasRetryAfterHeader && $options['retry_only_if_retry_after_header']):
                return false;
            default:
                $statusCode = $response ? $response->getStatusCode() : 0;
                return in_array($statusCode, $statuses, true);
        }
    }

    private function countRemainingRetries(array $options): int
    {
        $retryCount = isset($options['retry_count']) ? (int) $options['retry_count'] : 0;
        $numAllowed = isset($options['max_retry_attempts'])
            ? (int) $options['max_retry_attempts']
            : $this->defaultOptions['max_retry_attempts'];

        return (int) max([$numAllowed - $retryCount, 0]);
    }

    private function doRetry(RequestInterface $request, array $options, ResponseInterface $response = null): Promise
    {
        ++$options['retry_count'];
        $delayTimeout = $this->determineDelayTimeout($options, $response);

        if ($options['on_retry_callback']) {
            call_user_func_array(
                $options['on_retry_callback'],
                [
                    (int) $options['retry_count'],
                    $delayTimeout,
                    &$request,
                    &$options,
                    $response
                ]
            );
        }

        usleep((int) ($delayTimeout * 1e6));

        return $this($request, $options);
    }

    private function returnResponse(array $options, ResponseInterface $response): ResponseInterface
    {
        if ($options['expose_retry_header'] === false || $options['retry_count'] === 0) {
            return $response;
        }

        return $response->withHeader($options['retry_header'], $options['retry_count']);
    }

    private function determineDelayTimeout(array $options, ?ResponseInterface $response = null): float
    {
        $defaultDelayTimeout = (float) $options['default_retry_multiplier'] * $options['retry_count'];
        if (is_callable($options['default_retry_multiplier'])) {
            $defaultDelayTimeout = (float) call_user_func(
                $options['default_retry_multiplier'],
                $options['retry_count'],
                $response
            );
        }

        // Retry-After can be a delay in seconds or a date
        // (see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Retry-After)
        $timeout = abs($defaultDelayTimeout);
        if ($response && $response->hasHeader($options['retry_after_header'])) {
            $retryAfterHeader = $response->getHeader($options['retry_after_header']);
            $timeout = $this->deriveTimeoutFromHeader(
                $retryAfterHeader[0],
                $options['retry_after_date_format']
            ) ?? $defaultDelayTimeout;
        }

        if (!is_null($options['max_allowable_timeout_secs']) && abs($options['max_allowable_timeout_secs']) > 0) {
            return min(abs($timeout), (float) abs($options['max_allowable_timeout_secs']));
        }

        return abs($timeout);
    }

    private function deriveTimeoutFromHeader(string $headerValue, string $dateFormat = self::DATE_FORMAT): ?float
    {
        if (is_numeric($headerValue)) {
            return (float) trim($headerValue);
        }

        if ($date = DateTime::createFromFormat($dateFormat ?: self::DATE_FORMAT, trim($headerValue))) {
            return (float) $date->format('U') - time();
        }

        return null;
    }
}
