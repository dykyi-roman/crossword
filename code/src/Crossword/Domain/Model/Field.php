<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

final class Field
{
    /**
     * @var Cell[]
     */
    private array $grid;
    private int $coordinateX;
    private int $coordinateY;

    public function __construct(int $coordinateX, int $coordinateY)
    {
        $this->grid = [];
        $this->coordinateX = $coordinateX;
        $this->coordinateY = $coordinateY;

        $this->refresh();
    }

    public function refresh(): void
    {
        for ($counterY = 1; $counterY <= $this->coordinateY; $counterY++) {
            for ($counterX = 1; $counterX <= $this->coordinateX; $counterX++) {
                $coordinate = new Coordinate($counterX, $counterY);
                $this->grid[(string) $coordinate] = new Cell($coordinate, null);
            }
        }
    }

    /**
     * @return Cell[]
     */
    public function grid(): array
    {
        return $this->grid;
    }

    public function coordinateX(): int
    {
        return $this->coordinateX;
    }

    public function coordinateY(): int
    {
        return $this->coordinateY;
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

        $this->deadCell();
    }

    private function deadCell(): void
    {
        foreach ($this->grid as $cell) {
            if ($cell->isLetter()) {
                $left = $this->shift($cell->left())->letter();
                $right = $this->shift($cell->right())->letter();
                $top = $this->shift($cell->top())->letter();
                $down = $this->shift($cell->down())->letter();

                !$left && $right && $this->grid[(string) $cell->left()]->fill('');
                $left && !$right && $this->grid[(string) $cell->right()]->fill('');
                !$top && $down && $this->grid[(string) $cell->top()]->fill('');
                $top && !$down && $this->grid[(string) $cell->down()]->fill('');
            }
        }
    }

    private function shift(Coordinate $coordinate): Cell
    {
        if ($this->inFrame($coordinate)) {
            return $this->grid[(string) $coordinate];
        }

        return new Cell(new Coordinate(0, 0), null);
    }

    private function inFrame(Coordinate $coordinate): bool
    {
        return 0 !== $coordinate->coordinateX() &&
            0 !== $coordinate->coordinateY() &&
            $this->coordinateX() > $coordinate->coordinateX() &&
            $this->coordinateY() > $coordinate->coordinateY();
    }
}
