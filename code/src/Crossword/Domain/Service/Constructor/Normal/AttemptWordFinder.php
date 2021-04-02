<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Exception\NotFoundWordException;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Service\WordFinder;
use App\SharedKernel\Domain\Model\Mask;

final class AttemptWordFinder
{
    private const ATTEMPT = 3;

    private WordFinder $wordFinder;

    public function __construct(WordFinder $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    /**
     * @throws NotFoundWordException
     */
    public function find(string $language, Mask $mask, int $attempt = self::ATTEMPT): Word
    {
        $word = null;
        $counter = 1;
        $template = clone $mask;

        do {
            try {
                return $this->wordFinder->find($language, (string) $template);
            } catch (NotFoundWordException) {
                $counter++;
                $template = $template->shiftLeft();
            }
        } while ($counter <= $attempt);

        throw new NotFoundWordException();
    }
}
