<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Exception\NotFoundWordException;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Crossword;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;

final class NormalConstructor implements ConstructorInterface
{
    private Grid $grid;
    private AttemptWordFinder $attemptWordFinder;

    public function __construct(AttemptWordFinder $attemptWordFinder)
    {
        $this->grid = new Grid();
        $this->attemptWordFinder = $attemptWordFinder;
    }

    public function build(string $language, int $wordCount): Crossword
    {
        $crossword = new Crossword();

        if ($this->grid->isEmpty()) {
            $this->grid->draw(Row::withRandomRow());
            $this->nextWord(1, 8, $language, $crossword);
        }

        for ($counter = 2; $counter <= 37; $counter++) {
            $this->nextWord($counter, 5, $language, $crossword);
        }

        return $crossword;
    }

    private function nextWord(int $number, int $length, $language, Crossword $crossword): void
    {
        $rows = [...$this->grid->possibleXRows($length), ...$this->grid->possibleYRows($length)];
        shuffle($rows);

        /** @var Row $row */
        foreach ($rows as $row) {
            try {
                $word = $this->attemptWordFinder->find($language, $row->mask());
                $fillRow = $row->withFillWord($word->value()); // remove empty lasts cells
                dump($word->value(), $word);
                $this->grid->draw($fillRow);
                $crossword->addLine(new Line($number, $word, $fillRow));

                break;
            } catch (NotFoundWordException) {
                continue;
            }
        }
    }

    /**
     * @todo remove
     * @return Cell[]
     */
    public function grid(): array
    {
        return $this->grid->grid();
    }
}
