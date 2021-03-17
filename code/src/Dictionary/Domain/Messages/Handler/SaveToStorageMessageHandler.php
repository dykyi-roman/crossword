<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Exception\FailedWriteToStorageException;
use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Service\WordsStorageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveToStorageMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;
    private WordsStorageInterface $wordsStorage;

    public function __construct(WordsStorageInterface $wordsStorage, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->wordsStorage = $wordsStorage;
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
