<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Exception\NextLineFoundException;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Crossword;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\GridScanner;

final class NormalConstructor implements ConstructorInterface
{
    private AttemptWordFinder $attemptWordFinder;
    private GridScanner $gridScanner;

    public function __construct(AttemptWordFinder $attemptWordFinder, GridScanner $gridScanner)
    {
        $this->attemptWordFinder = $attemptWordFinder;
        $this->gridScanner = $gridScanner;
    }

    public function build(string $language, int $wordCount): Crossword
    {
        $crossword = new Crossword();
        $this->gridScanner->fill(Row::withRandomRow());
        for ($counter = 1; $counter <= $wordCount; $counter++) {
            $crossword = $crossword->withLine($this->nextLine($counter, $language));
        }

        return $crossword;
    }

    /**
     * @throws NextLineFoundException
     */
    private function nextLine(int $number, $language): Line
    {
        $rows = $this->gridScanner->scan();
        foreach ($rows as $row) {
            try {
                $word = $this->attemptWordFinder->find($language, $row->mask());
                $fillRow = $row->withFillWord($word->value()); // remove empty lasts cells
                dump($word);
                $this->gridScanner->fill($fillRow);

                return new Line($number, $word, $fillRow);
            } catch (WordFoundException) {
                continue;
            }
        }

        throw new NextLineFoundException($number);
    }

    /**
     * @todo remove
     */
    public function grid(): \ArrayIterator
    {
        return $this->gridScanner->grid()->getIterator();
    }
}
