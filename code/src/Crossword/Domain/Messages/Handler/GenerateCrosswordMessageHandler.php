<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Service\WordFinder;

final class GenerateCrosswordMessageHandler
{
    private WordFinder $wordFinder;

    public function __construct(WordFinder $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    public function __invoke(GenerateCrosswordMessage $message)
    {
        $word = $this->wordFinder->find($message->language(), '');
    }
}
