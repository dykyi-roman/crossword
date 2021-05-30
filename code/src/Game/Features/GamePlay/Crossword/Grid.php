<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

final class Grid
{
    private int $size;
    private array $field;

    public function __construct(array $crossword)
    {
        $this->size = $this->calculateGridSize($crossword);
        $this->field = $this->createNewGrid($this->size);
    }

    public function field(): array
    {
        return $this->field;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function fillLetter(array $cell): void
    {
        $this->field[$cell['coordinate']]['letter'] = $cell['letter'];
    }

    public function fillCrossLineNumbers(array $cell, int $index): void
    {
        $coordinate = $cell['coordinate'];

        $this->field[$coordinate]['index'] = array_key_exists('index', $this->field[$coordinate]) ?
            $this->field[$coordinate]['index'] . '/' . ($index + 1) :
            $index + 1;
    }

    public function fillLineNumbers(array $cell, int $index): void
    {
        $coordinate = $cell['coordinate'];

        $this->field[$coordinate]['number'] = array_key_exists('number', $this->field[$coordinate]) ?
            $this->field[$coordinate]['number'] . '/' . ($index + 1) :
            $index + 1;
    }

    private function calculateGridSize(array $crossword): int
    {
        $sizeX = $sizeY = 0;
        foreach ($crossword as $item) {
            foreach ($item['line'] as $cell) {
                $coordinate = explode('.', $cell['coordinate']);
                $coordinate[0] > $sizeX && $sizeX = $coordinate[0];
                $coordinate[1] > $sizeY && $sizeY = $coordinate[1];
            }
        }

        return (int) max([$sizeX, $sizeY]);
    }

    private function createNewGrid(int $size): array
    {
        $grid = [];
        for ($counterX = 1; $counterX <= $size; $counterX++) {
            for ($counterY = 1; $counterY <= $size; $counterY++) {
                $grid[sprintf('%s.%s', $counterX, $counterY)] = [
                    'letter' => '',
                    'coordinate' => [
                        'x' => $counterX,
                        'y' => $counterY,
                    ],
                ];
            }
        }

        return $grid;
    }
}
