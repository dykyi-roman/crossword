<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Handler;

use App\Dictionary\Domain\Messages\Message\WordMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class WordMessageHandler implements MessageHandlerInterface
{
    public function __invoke(WordMessage $message): void
    {
        dump($message); die();
    }
}
