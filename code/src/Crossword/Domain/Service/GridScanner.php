<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service;

use App\Crossword\Domain\Enum\Move;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;

final class GridScanner
{
    private const SCAN_ROW_LENGTH = 5;

    private Grid $grid;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return Row[]
     */
    public function scanRows(): array
    {
        $rows = [...$this->possibleXRows(), ...$this->possibleYRows()];
        shuffle($rows);

        return $rows;
    }

    public function fillLine(Line $line): void
    {
        $this->grid->fillLine($line);
    }

    /**
     * @return Row[]
     */
    private function possibleYRows(): array
    {
        $result = [];
        foreach ($this->grid as $cell) {
            if (!$cell->isLetter()) {
                continue;
            }

            $leftLine = $this->lineYScanner($cell, new Move(Move::LEFT), self::SCAN_ROW_LENGTH);
            $rightLine = $this->lineYScanner($cell, new Move(Move::RIGHT), self::SCAN_ROW_LENGTH);
            if (count($leftLine) || count($rightLine)) {
                $result[] = new Row(...array_merge(array_reverse($leftLine), [$cell], $rightLine));
            }
        }

        return $result;
    }

    /**
     * @return Row[]
     */
    private function possibleXRows(): array
    {
        $result = [];

        foreach ($this->grid as $cell) {
            if (!$cell->isLetter()) {
                continue;
            }

            $topLine = $this->lineXScanner($cell, new Move(Move::TOP), self::SCAN_ROW_LENGTH);
            $downLine = $this->lineXScanner($cell, new Move(Move::DOWN), self::SCAN_ROW_LENGTH);

            if (count($topLine) || count($downLine)) {
                $result[] = new Row(...array_reverse(array_merge(array_reverse($topLine), [$cell], $downLine)));
            }
        }

        return $result;
    }

    private function lineXScanner(Cell $cell, Move $move, int $length): array
    {
        $coordinate = $cell->coordinate();
        $cell = match ((string) $move->getValue()) {
            Move::TOP => $this->grid->shiftCell($coordinate->top()),
            Move::DOWN => $this->grid->shiftCell($coordinate->down()),
        };

        $line = [];
        for ($counter = 1; $counter <= $length; $counter++) {
            $coordinate = $cell->coordinate();
            $topCell = $this->grid->shiftCell($coordinate->top());
            $downCell = $this->grid->shiftCell($coordinate->down());
            $leftCell = $this->grid->shiftCell($coordinate->left());
            $rightCell = $this->grid->shiftCell($coordinate->right());

            if ($cell->isBlack() || !$coordinate->inFrame()) {
                return $line;
            }

            if ($topCell->isBlack() && $downCell->isLetter()) {
                return [];
            }

            if ($topCell->letter() && $downCell->isLetter()) {
                return [];
            }

            if ($topCell->letter() && $downCell->isBlack()) {
                return [];
            }

            if (!($leftCell->isEmpty() && $rightCell->isEmpty())) {
                array_pop($line);

                return $line;
            }

            $line[] = $cell;

            $cell = match ((string) $move->getValue()) {
                Move::TOP => $topCell,
                Move::DOWN => $downCell,
            };

            if ($length === $counter && $cell->isLetter()) {
                array_pop($line);
            }
        }

        return $line;
    }

    private function lineYScanner(Cell $cell, Move $move, int $length): array
    {
        $coordinate = $cell->coordinate();
        $cell = match ((string) $move->getValue()) {
            Move::LEFT => $this->grid->shiftCell($coordinate->left()),
            Move::RIGHT => $this->grid->shiftCell($coordinate->right()),
        };

        $line = [];
        for ($counter = 1; $counter <= $length; $counter++) {
            $coordinate = $cell->coordinate();
            $topCell = $this->grid->shiftCell($coordinate->top());
            $downCell = $this->grid->shiftCell($coordinate->down());
            $leftCell = $this->grid->shiftCell($coordinate->left());
            $rightCell = $this->grid->shiftCell($coordinate->right());

            if ($cell->isBlack() || !$coordinate->inFrame()) {
                return $line;
            }

            if ($leftCell->isBlack() && $rightCell->isLetter()) {
                return [];
            }

            if ($leftCell->letter() && $rightCell->isLetter()) {
                return [];
            }

            if ($leftCell->letter() && $rightCell->isBlack()) {
                return [];
            }

            if (!($topCell->isEmpty() && $downCell->isEmpty())) {
                array_pop($line);

                return $line;
            }

            $line[] = $cell;

            $cell = match ((string) $move->getValue()) {
                Move::LEFT => $leftCell,
                Move::RIGHT => $rightCell,
            };

            if ($length === $counter && $cell->isLetter()) {
                array_pop($line);
            }
        }

        return $line;
    }
}
