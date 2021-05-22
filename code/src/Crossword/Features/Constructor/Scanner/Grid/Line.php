<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Scanner\Grid;

use App\Crossword\Features\Constructor\Scanner\Exception\WordNotFitException;
use ArrayIterator;
use IteratorAggregate;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class Line implements IteratorAggregate, JsonSerializable
{
    private Row $row;

    public function __construct(Row $row)
    {
        $this->row = clone $row;
    }

    public static function withLetter(Row $row, string $letter): self
    {
        return new Line(Row::withCell($row, 0, Cell::withLetter($row->cell(0), $letter)));
    }

    public static function withWord(Row $row, string $word): self
    {
        for ($counter = 0; $counter < 3; $counter++) {
            if (self::suitablePosition($row, $word)) {
                return new Line(self::fillRow($row, $word));
            }

            $cell = $row->cell(0);
            $cell->isEmpty() && $row = $row->remove(0);
        }

        throw new WordNotFitException();
    }

    private static function suitablePosition(Row $row, string $word): bool
    {
        foreach ($row as $index => $cell) {
            if ($cell->isLetter() && strlen($word) >= $index + 1 && $word[(int) $index] === $cell->letter()) {
                return true;
            }
        }

        return false;
    }

    private static function fillRow(Row $row, string $word): Row
    {
        $withWord = [];
        $length = strlen($word);
        for ($counter = 0; $counter < $length; $counter++) {
            $withWord[] = Cell::withLetter($row->cell($counter), $word[$counter]);
        }

        return new Row(...$withWord);
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
}
