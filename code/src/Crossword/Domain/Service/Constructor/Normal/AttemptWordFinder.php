<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Mask;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Service\WordFinder;

final class AttemptWordFinder
{
    private const ATTEMPT = 3;

    private WordFinder $wordFinder;

    public function __construct(WordFinder $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    /**
     * @throws WordFoundException
     */
    public function find(string $language, Mask $mask, int $attempt = self::ATTEMPT): Word
    {
        $counter = 1;
        $template = clone $mask;

        do {
            try {
                return $this->wordFinder->search(new WordSearchCriteria($language, (string) $template));
            } catch (WordFoundException) {
                $counter++;
                $template = $template->shiftLeft();
            }
        } while ($counter <= $attempt);

        throw new WordFoundException();
    }
}
