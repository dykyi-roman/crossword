<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use App\Crossword\Domain\Enum\Move;

final class Grid
{
    /**
     * @var Cell[]
     */
    private array $grid;

    public function __construct()
    {
        $this->grid = [];
    }

    /**
     * @return Cell[]
     * @todo remove
     */
    public function grid(): array
    {
        return $this->grid;
    }

    public function isEmpty(): bool
    {
        return 0 === count(array_filter($this->grid, static fn (Cell $cell) => null !== $cell->letter()));
    }

    public function draw(Row $row): void
    {
        foreach ($row->cells() as $cell) {
            $this->grid[(string) $cell->coordinate()] = $cell;
        }

        $this->fillBlackSquare();
    }

    /**
     * @return Row[]
     */
    public function possibleYRows(int $length): array
    {
        $result = [];
        foreach ($this->grid as $cell) {
            if (!$cell->isLetter()) {
                continue;
            }

            $leftCell = $this->shiftCell($cell->coordinate()->left());
            $rightCell = $this->shiftCell($cell->coordinate()->right());

            $leftLine = $this->lineYScanner($leftCell, new Move(Move::LEFT), $length);
            $rightLine = $this->lineYScanner($rightCell, new Move(Move::RIGHT), $length);
            if (count($leftLine) || count($rightLine)) {
                $result[] = new Row(...$this->possibleVariants($leftLine, $cell, $rightLine));
            }
        }

        return $result;
    }

    /**
     * @return Row[]
     */
    public function possibleXRows(int $length): array
    {
        $result = [];
        foreach ($this->grid as $cell) {
            if (!$cell->isLetter()) {
                continue;
            }

            $topCell = $this->shiftCell($cell->coordinate()->top());
            $downCell = $this->shiftCell($cell->coordinate()->down());

            $topLine = $this->lineXScanner($topCell, new Move(Move::TOP), $length);
            $downLine = $this->lineXScanner($downCell, new Move(Move::DOWN), $length);

            if (count($topLine) || count($downLine)) {
                $result[] = new Row(...array_reverse($this->possibleVariants($topLine, $cell, $downLine)));
            }
        }

        return $result;
    }

    /**
     * @example
     * _ _ _ _ a _ _ _ _
     * _ a _ _ _ _ _ _ _
     * _ _ _ _ _ _ _a_ _
     */
    private function possibleVariants(array $left, Cell $cell, array $right): array
    {
        $leftCount = count($left);
        if ($leftCount >= 2 && $leftCount === count($right)) {
            return array_merge([$left[1], $left[0]], [$cell], $right);
        }

        return array_merge(array_reverse($left), [$cell], $right);
    }

    private function lineYScanner(Cell $cell, Move $move, int $length): array
    {
        $line = [];
        for ($counter = 1; $counter <= $length; $counter++) {
            $coordinate = $cell->coordinate();
            $topCell = $this->shiftCell($coordinate->top());
            $downCell = $this->shiftCell($coordinate->down());
            $leftCell = $this->shiftCell($coordinate->left());
            $rightCell = $this->shiftCell($coordinate->right());

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

    private function lineXScanner(Cell $cell, Move $move, int $length): array
    {
        $line = [];
        for ($counter = 1; $counter <= $length; $counter++) {
            $coordinate = $cell->coordinate();
            $topCell = $this->shiftCell($coordinate->top());
            $downCell = $this->shiftCell($coordinate->down());
            $leftCell = $this->shiftCell($coordinate->left());
            $rightCell = $this->shiftCell($coordinate->right());

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

    private function fillBlackSquare(): void
    {
        foreach ($this->grid as $cell) {
            if ($cell->isLetter()) {
                $coordinate = $cell->coordinate();
                $leftCell = $this->shiftCell($coordinate->left());
                $rightCell = $this->shiftCell($coordinate->right());
                $topCell = $this->shiftCell($coordinate->top());
                $downCell = $this->shiftCell($coordinate->down());

                !$leftCell->letter() && $rightCell->letter() && $this->fillCellBlack($coordinate->left());
                $leftCell->letter() && !$rightCell->letter() && $this->fillCellBlack($coordinate->right());
                !$topCell->letter() && $downCell->letter() && $this->fillCellBlack($coordinate->top());
                $topCell->letter() && !$downCell->letter() && $this->fillCellBlack($coordinate->down());
            }
        }
    }

    private function fillCellBlack(Coordinate $coordinate): void
    {
        $this->grid[(string) $coordinate] = new Cell($coordinate, '');
    }

    private function exist(Coordinate $coordinate): bool
    {
        return array_key_exists((string) $coordinate, $this->grid);
    }

    private function shiftCell(Coordinate $coordinate): Cell
    {
        if ($coordinate->inFrame() && $this->exist($coordinate)) {
            return $this->grid[(string) $coordinate];
        }

        return new Cell($coordinate, null);
    }
}
