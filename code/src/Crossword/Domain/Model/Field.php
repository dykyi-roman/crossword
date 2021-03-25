<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

final class Field
{
    /**
     * @var Cell[]
     */
    private array $grid;
    private int $pivotX;
    private int $pivotY;

    public function __construct(int $pivotX, int $pivotY)
    {
        $this->grid = [];
        $this->pivotX = $pivotX;
        $this->pivotY = $pivotY;

        $this->refresh();
    }

    public function refresh(): void
    {
        for ($pivotX = 1; $pivotX <= $this->pivotX; $pivotX++) {
            for ($pivotY = 1; $pivotY <= $this->pivotY; $pivotY++) {
                $this->grid[] = new Cell(new Coordinate($pivotX, $pivotY), null);
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

    public function pivotX(): int
    {
        return $this->pivotX;
    }

    public function pivotY(): int
    {
        return $this->pivotX;
    }

    public function isEmpty(): bool
    {
        return 0 === count(array_filter($this->grid, static fn (Cell $cell) => null !== $cell->letter()));
    }

    public function draw(Cell ...$cells): void
    {
        foreach ($cells as $cell) {
            $this->fill($cell);
        }
    }

    private function fill(Cell $value): void
    {
        foreach ($this->grid as $cell) {
            $coordinate = $cell->coordinate();
            if ($coordinate->equals($value->coordinate())) {
                $cell->fill($value->letter());

                return;
            }
        }
    }
}
