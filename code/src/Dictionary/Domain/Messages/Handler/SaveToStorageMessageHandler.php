<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Repository\WriteWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\FailedSaveToStorageException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveToStorageMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private WriteWordsStorageInterface $writeWordsStorage;

    public function __construct(WriteWordsStorageInterface $writeWordsStorage, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->writeWordsStorage = $writeWordsStorage;
    }

    public function __invoke(SaveToStorageMessage $message)
    {
        try {
            $this->writeWordsStorage->save($message->word());
        } catch (FailedSaveToStorageException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
