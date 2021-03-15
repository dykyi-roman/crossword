<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\FailedWriteToStorageException;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Service\WordsStorageInterface;
use Psr\Log\LoggerInterface;

final class SaveToStorageMessageHandler
{
    private LoggerInterface $logger;
    private WordsStorageInterface $wordsStorage;

    public function __construct(WordsStorageInterface $wordsStorage, LoggerInterface $logger)
    {
        $this->wordsStorage = $wordsStorage;
        $this->logger = $logger;
    }

    public function __invoke(SaveToStorageMessage $message)
    {
        try {
            $this->wordsStorage->add($message->word());
        } catch (FailedWriteToStorageException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
