<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class LoggerMiddleware
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(callable $handler): callable
    {
        $logger = $this->logger;

        return static function (callable $handler) use ($logger) {
            return static function (RequestInterface $request, array $options) use ($handler, $logger) {
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($request, $logger) {
                        $body = $request->getBody();
                        $logger->info($body->getContents());
                        $logger->info($body->getContents());

                        return $response;
                    }
                );
            };
        };
    }
}
