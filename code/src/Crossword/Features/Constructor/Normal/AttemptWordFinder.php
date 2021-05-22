<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Normal;

use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use App\Crossword\Features\Constructor\Scanner\Grid\RowMask;
use App\Crossword\Features\Constructor\WordFinder;
use App\Crossword\Features\Constructor\WordFoundException;

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
    public function find(string $language, RowMask $mask, int $attempt = self::ATTEMPT): Word
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
