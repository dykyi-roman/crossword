<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Scanner;

use App\Crossword\Features\Constructor\Scanner\Grid\Cell;
use App\Crossword\Features\Constructor\Scanner\Grid\Coordinate;
use App\Crossword\Features\Constructor\Scanner\Grid\Grid;
use App\Crossword\Features\Constructor\Scanner\Grid\Row;

final class RowYScanner
{
    /**
     * @return Row[]
     */
    public function scan(Grid $grid, int $length): array
    {
        $result = [];
        foreach ($grid as $cell) {
            if (!$cell->isLetter()) {
                continue;
            }

            $leftLine = $this->doScan($grid, $cell, new Move(Move::LEFT), $length);
            $rightLine = $this->doScan($grid, $cell, new Move(Move::RIGHT), $length);
            if (count($leftLine) || count($rightLine)) {
                $result[] = new Row(...array_merge(array_reverse($leftLine), [$cell], $rightLine));
            }
        }

        return $result;
    }

    private function doScan(Grid $grid, Cell $cell, Move $move, int $length): array
    {
        $cell = $this->startCell($grid, $cell, $move);

        $line = [];
        for ($counter = 1; $counter <= $length; $counter++) {
            $coordinate = $cell->coordinate();

            if ($cell->isBlack() || !$coordinate->inFrame()) {
                return $line;
            }

            if (!$this->isFitRow($grid, $coordinate)) {
                return [];
            }

            $topCell = $grid->shiftCell($coordinate->top());
            $downCell = $grid->shiftCell($coordinate->down());
            if (!($topCell->isEmpty() && $downCell->isEmpty())) {
                array_pop($line);

                return $line;
            }

            $line[] = $cell;
            $cell = $this->nextCell($grid, $move, $coordinate);
            if ($length === $counter && $cell->isLetter()) {
                array_pop($line);
            }
        }

        return $line;
    }

    private function isFitRow(Grid $grid, Coordinate $coordinate): bool
    {
        $leftCell = $grid->shiftCell($coordinate->left());
        $rightCell = $grid->shiftCell($coordinate->right());

        if ($leftCell->isBlack() && $rightCell->isLetter()) {
            return false;
        }

        if ($leftCell->letter() && $rightCell->isLetter()) {
            return false;
        }

        if ($leftCell->letter() && $rightCell->isBlack()) {
            return false;
        }

        return true;
    }

    private function nextCell(Grid $grid, Move $move, Coordinate $coordinate): Cell
    {
        $leftCell = $grid->shiftCell($coordinate->left());
        $rightCell = $grid->shiftCell($coordinate->right());

        return match ((string) $move->getValue()) {
            Move::LEFT => $leftCell,
            Move::RIGHT => $rightCell,
        };
    }

    private function startCell(Grid $grid, Cell $cell, Move $move): Cell
    {
        $coordinate = $cell->coordinate();

        return match ((string) $move->getValue()) {
            Move::LEFT => $grid->shiftCell($coordinate->left()),
            Move::RIGHT => $grid->shiftCell($coordinate->right()),
        };
    }
}
