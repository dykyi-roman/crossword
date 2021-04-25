<?php

declare(strict_types=1);

namespace App\Tests;

use Faker\Factory;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class CrosswordTestCase extends TestCase
{
    protected function messageBusMock(): MessageBusInterface
    {
        return new class implements MessageBusInterface {
            public function dispatch($message, array $stamps = []): Envelope
            {
                return new Envelope($message);
            }
        };
    }

    protected function messageBusMockWithConsecutive(
        InvocationOrder $invocationRule,
        $message = null
    ): MessageBusInterface {
        if (null === $message) {
            $messageBus = $this->createMock(MessageBusInterface::class);
            $messageBus->expects($invocationRule)->method('dispatch');

            return $messageBus;
        }

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($invocationRule)
            ->method('dispatch')
            ->withConsecutive(
                [
                    self::isInstanceOf(get_class($message)),
                ]
            )
            ->willReturn(new Envelope($message));

        return $messageBus;
    }

    protected function createTempFile(string $ext = '.tmp', array $data = []): string
    {
        $filePath = sys_get_temp_dir() . uniqid(Factory::create()->name, true) . $ext;
        foreach ($data as $item) {
            file_put_contents($filePath, $item . PHP_EOL, FILE_APPEND);
        }

        return $filePath;
    }
}
