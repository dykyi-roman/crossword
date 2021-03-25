<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Exception\NotFoundWordException;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Service\WordFinder;

final class FirstWordFinder
{
    private const ATTEMPT = 3;

    private WordFinder $wordFinder;

    public function __construct(WordFinder $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    public function find(string $language, string $mask): Word
    {
        $word = null;
        $counter = 1;
        $template = $mask;
        do {
            try {
                $word = $this->wordFinder->find($language, $template);
                $counter = self::ATTEMPT + 1;
            } catch (NotFoundWordException) {
                $counter++;
                $template = substr($template, 0, -1);
            }
        } while ($counter <= self::ATTEMPT);

        return $word ?? throw new NotFoundWordException();
    }
}
