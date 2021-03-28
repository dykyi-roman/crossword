<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Messenger\Middleware;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class AuditMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $className = get_class($message);

        $body = [];
        foreach ((array) $message as $key => $value) {
            $body[$this->receivedVariableName($key, $className)] = $value;
        }

        $this->logger->info(sprintf('Received & handling %s', $className), $body);

        return $stack->next()->handle($envelope, $stack);
    }

    private function receivedVariableName(string $name, string $class): string
    {
        return (string) preg_replace('/[\x00-\x1F\x7F]/', '', (string) str_replace($class, '', $name));
    }
}
