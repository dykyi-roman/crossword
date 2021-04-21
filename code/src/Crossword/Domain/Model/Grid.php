<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use ArrayIterator;
use IteratorAggregate;

final class Grid implements IteratorAggregate
{
    /**
     * @var Cell[]
     */
    private array $cells;

    public function __construct()
    {
        $this->cells = [];
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->cells);
    }

    public function isEmpty(): bool
    {
        return 0 === count(array_filter($this->cells, static fn (Cell $cell) => null !== $cell->letter()));
    }

    public function shiftCell(Coordinate $coordinate): Cell
    {
        if ($coordinate->inFrame() && $this->exist($coordinate)) {
            return $this->cells[(string) $coordinate];
        }

        return new Cell($coordinate, null);
    }

    public function fillLine(Line $line): void
    {
        /** @var Cell $cell */
        foreach ($line as $cell) {
            if ($cell->isLetter()) {
                $this->cells[(string) $cell->coordinate()] = $cell;
            }
        }

        array_map([$this, 'fillBlackSquare'], $this->cells);
    }

    private function fillBlackSquare(Cell $cell): void
    {
        $cell->isLetter() && $this->searchBlackSquare($cell->coordinate());
    }

    private function searchBlackSquare(Coordinate $coordinate): void
    {
        $leftCell = $this->shiftCell($coordinate->left());
        $rightCell = $this->shiftCell($coordinate->right());
        $topCell = $this->shiftCell($coordinate->top());
        $downCell = $this->shiftCell($coordinate->down());

        $leftCoordinate = $coordinate->left();
        if ($leftCoordinate->inFrame() && !$leftCell->letter() && $rightCell->letter()) {
            $this->fillCellBlack($coordinate->left());
        }

        $topCoordinate = $coordinate->top();
        if ($topCoordinate->inFrame() && !$topCell->letter() && $downCell->letter()) {
            $this->fillCellBlack($coordinate->top());
        }

        if ($leftCell->letter() && !$rightCell->letter()) {
            $this->fillCellBlack($coordinate->right());
        }

        if ($topCell->letter() && !$downCell->letter()) {
            $this->fillCellBlack($coordinate->down());
        }
    }

    private function fillCellBlack(Coordinate $coordinate): void
    {
        $this->cells[(string) $coordinate] = new Cell($coordinate, '');
    }

    private function exist(Coordinate $coordinate): bool
    {
        return array_key_exists((string) $coordinate, $this->cells);
    }
}
