<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Scanner;

use App\Crossword\Features\Constructor\Scanner\Grid\Cell;
use App\Crossword\Features\Constructor\Scanner\Grid\Coordinate;
use App\Crossword\Features\Constructor\Scanner\Grid\Grid;
use App\Crossword\Features\Constructor\Scanner\Grid\Row;

final class RowXScanner
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

            $topLine = $this->doScan($grid, $cell, new Move(Move::TOP), $length);
            $downLine = $this->doScan($grid, $cell, new Move(Move::DOWN), $length);

            if (count($topLine) || count($downLine)) {
                $result[] = new Row(...array_reverse(array_merge(array_reverse($topLine), [$cell], $downLine)));
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

            $leftCell = $grid->shiftCell($coordinate->left());
            $rightCell = $grid->shiftCell($coordinate->right());
            if (!($leftCell->isEmpty() && $rightCell->isEmpty())) {
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
        $topCell = $grid->shiftCell($coordinate->top());
        $downCell = $grid->shiftCell($coordinate->down());

        if ($topCell->isBlack() && $downCell->isLetter()) {
            return false;
        }

        if ($topCell->letter() && $downCell->isLetter()) {
            return false;
        }

        if ($topCell->letter() && $downCell->isBlack()) {
            return false;
        }

        return true;
    }

    private function nextCell(Grid $grid, Move $move, Coordinate $coordinate): Cell
    {
        $topCell = $grid->shiftCell($coordinate->top());
        $downCell = $grid->shiftCell($coordinate->down());

        return match ((string) $move->getValue()) {
            Move::TOP => $topCell,
            Move::DOWN => $downCell,
        };
    }

    private function startCell(Grid $grid, Cell $cell, Move $move): Cell
    {
        $coordinate = $cell->coordinate();

        return match ((string) $move->getValue()) {
            Move::TOP => $grid->shiftCell($coordinate->top()),
            Move::DOWN => $grid->shiftCell($coordinate->down()),
        };
    }
}
