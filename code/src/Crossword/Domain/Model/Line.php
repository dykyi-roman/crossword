<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use App\Crossword\Domain\Exception\WordNotFitException;
use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;

final class Line implements IteratorAggregate, JsonSerializable
{
    private Row $row;

    public function __construct(Row $row)
    {
        $this->row = clone $row;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->row->getIterator();
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function jsonSerialize(): array
    {
        return array_map(static fn (Cell $cell) => $cell->jsonSerialize(), $this->getIterator()->getArrayCopy());
    }

    public function fillLetter(string $letter): self
    {
        $row = clone $this->row;

        $cell = $row->cell(0);
        $cell->fillLetter($letter);

        return new Line($row);
    }

    public function fillWord(string $word): self
    {
        $row = clone $this->row;

        for ($counter = 0; $counter < 3; $counter++) {
            if ($this->suitablePosition($row, $word)) {
                return new Line($this->fillRow($row, $word));
            }

            $cell = $row->cell(0);
            $cell->isEmpty() && $row = $row->remove(0);
        }

        throw new WordNotFitException();
    }

    private function suitablePosition(Row $row, string $word): bool
    {
        foreach ($row as $index => $cell) {
            if ($cell->isLetter() && strlen($word) >= $index + 1 && $word[(int) $index] === $cell->letter()) {
                return true;
            }
        }

        return false;
    }

    private function fillRow(Row $row, string $word): Row
    {
        $withWord = [];
        $length = strlen($word);
        for ($counter = 0; $counter < $length; $counter++) {
            $cell = $row->cell($counter);
            $cell->fillLetter($word[$counter]);
            $withWord[] = $cell;
        }

        return new Row(...$withWord);
    }
}
