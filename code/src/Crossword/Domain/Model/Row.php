<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use App\Crossword\Domain\Exception\CellNotFoundException;
use App\SharedKernel\Domain\Exception\SearchMaskIsShortException;
use App\SharedKernel\Domain\Model\Mask;
use ArrayIterator;
use IteratorAggregate;

/**
 * @psalm-immutable
 */
final class Row implements IteratorAggregate
{
    /**
     * @var Cell[]
     */
    private array $cells;

    public function __construct(Cell ...$cells)
    {
        $this->cells = $cells;
    }

    public static function withRandomRow(): self
    {
        $coordinateX = intdiv(20, 2) - random_int(1, 5);
        $coordinateY = intdiv(20, 2) - random_int(1, 5);
        $coordinate = new Coordinate($coordinateX, $coordinateY);

        return new self(new Cell($coordinate, null));
    }

    public static function withCell(Row $row, int $position, Cell $cell): self
    {
        $row = clone $row;
        $cells = $row->cells();
        if (array_key_exists($position, $row->cells())) {
            $cells[$position] = $cell;
        }

        return new self(...$cells);
    }

    public function cells(): array
    {
        return $this->cells;
    }

    /**
     * @throws CellNotFoundException
     */
    public function cell(int $index): Cell
    {
        if (array_key_exists($index, $this->cells)) {
            return $this->cells[$index];
        }

        throw new CellNotFoundException();
    }

    public function remove(int $index): self
    {
        if (array_key_exists($index, $this->cells)) {
            $row = new self(...$this->cells);
            unset($row->cells[$index]);
            $row->cells = array_values($row->cells);

            return $row;
        }

        return $this;
    }

    /**
     * @throws SearchMaskIsShortException
     *
     * @example
     *  _ _ _ _ _ a  ===>  _ _ _ _ _ a.*{0,6}
     *  _ _ _ _ a _  ===>  _ _ _ _ a .*{0,6}
     *  _ _ _ a _ _  ===>  _ _ _ a .*{0,6}
     *  _ _ _ _ _ _  ===>  .*{0,6}
     *  a _ _ _ _ _  ===>  a.*{0,6}
     *  _ a _ _ _ _  ===>  _ a .*{0,6}
     *   _ _a _  _ _ ===>  _ _ a .*{0,6}
     */
    public function mask(): Mask
    {
        $mask = array_map(static fn (Cell $cell) => $cell->letter() ?: '.', $this->cells);
        $mask = implode('', $mask);
        while (substr($mask, -1) === '.') {
            $mask = substr($mask, 0, -1);
        }

        return new Mask(sprintf('%s.*{0,%d}', $mask, count($this->cells)));
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->cells);
    }
}
