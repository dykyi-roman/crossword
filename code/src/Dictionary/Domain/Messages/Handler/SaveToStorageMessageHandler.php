<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Messages\Message\SaveToStorageMessage;
use App\Dictionary\Domain\Repository\WriteWordsStorageInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SaveToStorageMessageHandler implements MessageHandlerInterface
{
    private WriteWordsStorageInterface $writeWordsStorage;

    public function __construct(WriteWordsStorageInterface $writeWordsStorage)
    {
        $this->writeWordsStorage = $writeWordsStorage;
    }

    public function __invoke(SaveToStorageMessage $message)
    {
        $this->writeWordsStorage->save($message->language(), $message->word());
    }
}
