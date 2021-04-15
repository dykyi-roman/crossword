<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Domain\Service\CrosswordConstructor;

final class Game
{
    private int $size;
    private array $grid;
    private CrosswordConstructor $constructor;

    public function __construct(CrosswordConstructor $constructor)
    {
        $this->constructor = $constructor;
    }

    public function new(): void
    {
        $crossword = $this->constructor->construct('en', 'normal', 4);
        $this->size = $this->calculateGridSize($crossword);
        $this->grid = $this->emptyGrid($this->size);
        foreach ($crossword as $item) {
            foreach ($item['line'] as $cell) {
                $this->grid[sprintf('%s.%s', $cell['coordinate']['x'], $cell['coordinate']['y'])] = $cell;
            }
        }
    }

    public function grid(): array
    {
        return $this->grid;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function calculateGridSize(array $crossword): int
    {
        $sizeX = $sizeY = 0;
        foreach ($crossword as $item) {
            foreach ($item['line'] as $cell) {
                $cell['coordinate']['x'] > $sizeX && $sizeX = $cell['coordinate']['x'];
                $cell['coordinate']['y'] > $sizeY && $sizeY = $cell['coordinate']['y'];
            }
        }

        return (int) max([$sizeX, $sizeY]);
    }

    private function emptyGrid(int $size): array
    {
        $grid = [];
        for ($counterX = 1; $counterX <= $size; $counterX++) {
            for ($counterY = 1; $counterY <= $size; $counterY++) {
                $grid[sprintf('%s.%s', $counterX, $counterY)] = ['letter' => '', 'coordinate' => ['x' => $counterX, 'y' => $counterY]];
            }
        }

        return $grid;
    }
}
