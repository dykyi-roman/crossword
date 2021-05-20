<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\SaveStorage\Message;

use App\Dictionary\Features\PopulateStorage\SaveStorage\Storage\WriteWordsStorageInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveToStorageMessageHandler implements MessageHandlerInterface
{
    private WriteWordsStorageInterface $writeWordsStorage;

    public function __construct(WriteWordsStorageInterface $writeWordsStorage)
    {
        $this->writeWordsStorage = $writeWordsStorage;
    }

    public function __invoke(SaveToStorageMessage $message): void
    {
        $this->writeWordsStorage->save($message->language(), $message->word());
    }
}
