<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use App\Crossword\Domain\Enum\Axis;
use App\Crossword\Domain\Enum\Move;

final class Field
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
     */
    public function grid(): array
    {
        return $this->grid;
    }

    public function isEmpty(): bool
    {
        return 0 === count(array_filter($this->grid, static fn (Cell $cell) => null !== $cell->letter()));
    }

    public function draw(Cell ...$cells): void
    {
        foreach ($cells as $cell) {
            $this->grid[(string) $cell->coordinate()] = $cell;
        }

        $this->markForbiddenCells();
    }

    public function possibleYLines(): array
    {
        $axisYLines = [];
        foreach ($this->grid as $cell) {
            if ($cell->isLetter()) {
                $leftLine = $this->lineYScanner($this->shiftCell($cell->left()), new Move(Move::LEFT), 5);
                $rightLine = $this->lineYScanner($this->shiftCell($cell->right()), new Move(Move::RIGHT), 5);

                if (count($leftLine) || count($rightLine)) {
                    $line = $this->possibleVariant($leftLine, $cell, $rightLine);
                    $axisYLines[$cell->coordinate()->coordinateY()] = $line;
                }
            }
        }

        return $axisYLines;
    }

    public function possibleXLines(): array
    {
        $axisXLines = [];
        foreach ($this->grid as $cell) {
            if ($cell->isLetter()) {
                $topLine = $this->lineXScanner($this->shiftCell($cell->top()), new Move(Move::TOP), 5);
                $downLine = $this->lineXScanner($this->shiftCell($cell->down()), new Move(Move::DOWN), 5);

                if (count($topLine) || count($downLine)) {
                    $line = $this->possibleVariant($topLine, $cell, $downLine);
                    $axisXLines[$cell->coordinate()->coordinateX()] = $line;
                }
            }
        }

        return $axisXLines;
    }

    /**
     * @example
     * _ _ _ _ a _ _ _ _
     * _ a _ _ _ _ _ _ _
     * _ _ _ _ _ _ _a_ _
     */
    private function possibleVariant(array $left, Cell $cell, array $right): array
    {
        if (count($left) === count($right)) {
            return array_reverse(array_merge([$left[1], $left[0]], [$cell], $right));
        }

        return array_reverse(array_merge(array_reverse($left), [$cell], $right));
    }

    private function lineYScanner(Cell $cell, Move $move, int $steps): array
    {
        $line = [];
        for ($counter = 1; $counter <= $steps; $counter++) {
            if ($cell->isForbidden() || !$cell->coordinate()->inFrame()) {
                return $line;
            }

            if ($this->shiftCell($cell->left())->isForbidden() && $this->shiftCell($cell->right())->isLetter()) {
                return [];
            }

            if ($this->shiftCell($cell->left())->letter() && $this->shiftCell($cell->right())->isLetter()) {
                return [];
            }

            if ($this->shiftCell($cell->left())->letter() && $this->shiftCell($cell->right())->isForbidden()) {
                return [];
            }

            if ($steps === $counter && $cell->isLetter()) {
                return [array_pop($line)];
            }

            $topCell = $this->shiftCell($cell->top());
            $downCell = $this->shiftCell($cell->down());
            if ($topCell->isEmpty() && $downCell->isEmpty()) {
                $line[] = $cell;
            } else {
                return $line;
            }


            $cell = match ((string) $move->getValue()) {
                Move::LEFT => $this->shiftCell($cell->left()),
                Move::RIGHT => $this->shiftCell($cell->right()),
            };
        }

        return $line;
    }

    private function lineXScanner(Cell $cell, Move $move, int $steps): array
    {
        $line = [];
        for ($counter = 1; $counter <= $steps; $counter++) {
            if ($cell->isForbidden() || !$cell->coordinate()->inFrame()) {
                return $line;
            }

            if ($this->shiftCell($cell->top())->isForbidden() && $this->shiftCell($cell->down())->isLetter()) {
                return [];
            }

            if ($this->shiftCell($cell->top())->letter() && $this->shiftCell($cell->down())->isLetter()) {
                return [];
            }

            if ($this->shiftCell($cell->top())->letter() && $this->shiftCell($cell->down())->isForbidden()) {
                return [];
            }

            if ($steps === $counter && $cell->isLetter()) {
                return array_pop($line);
            }

            $leftCell = $this->shiftCell($cell->left());
            $rightCell = $this->shiftCell($cell->right());

            if ($leftCell->isEmpty() && $rightCell->isEmpty()) {
                $line[] = $cell;
            } else {
                return $line;
            }

            $cell = match ((string) $move->getValue()) {
                Move::TOP => $this->shiftCell($cell->top()),
                Move::DOWN => $this->shiftCell($cell->down()),
            };
        }

        return $line;
    }

    private function markForbiddenCells(): void
    {
        foreach ($this->grid as $cell) {
            if ($cell->isLetter()) {
                $leftCell = $this->shiftCell($cell->left());
                $rightCell = $this->shiftCell($cell->right());
                $topCell = $this->shiftCell($cell->top());
                $downCell = $this->shiftCell($cell->down());

                !$leftCell->letter() && $rightCell->letter() && $this->fillCell($cell->left());
                $leftCell->letter() && !$rightCell->letter() && $this->fillCell($cell->right());
                !$topCell->letter() && $downCell->letter() && $this->fillCell($cell->top());
                $topCell->letter() && !$downCell->letter() && $this->fillCell($cell->down());
            }
        }
    }

    private function fillCell(Coordinate $coordinate): void
    {
        $this->grid[(string) $coordinate] = new Cell($coordinate, '');
    }

    private function exist(Coordinate $coordinate): bool
    {
        return array_key_exists((string) $coordinate, $this->grid());
    }

    private function shiftCell(Coordinate $coordinate): Cell
    {
        if ($coordinate->inFrame() && $this->exist($coordinate)) {
            return $this->grid[(string) $coordinate];
        }

        return new Cell($coordinate, null);
    }
}
