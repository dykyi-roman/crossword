<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

/**
 * @psalm-immutable
 */
final class GameDto
{
    private int $size;
    private array $grid;
    private array $definitions;

    public function __construct(array $grid, int $size, array $definitions)
    {
        $this->grid = $grid;
        $this->size = $size;
        $this->definitions = $definitions;
    }

    public function grid(): array
    {
        return $this->grid;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function definitions(): array
    {
        return $this->definitions;
    }
}
