<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Messenger\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class FailureLoggerMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $next = $stack->next();

        try {
            return $next->handle($envelope, $stack);
        } catch (HandlerFailedException $exception) {
            $this->logger->error($exception->getMessage());

            throw $exception;
        }
    }
}
