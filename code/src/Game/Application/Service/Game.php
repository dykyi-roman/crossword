<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Application\Dto\GameDto;
use App\Game\Domain\Service\CrosswordConstructor;

final class Game
{
    private CrosswordConstructor $constructor;

    public function __construct(CrosswordConstructor $constructor)
    {
        $this->constructor = $constructor;
    }

    public function new(string $language, string $type, int $wordCount): GameDto
    {
        $crossword = $this->constructor->construct($language, $type, $wordCount);
        $size = $this->calculateGridSize($crossword);
        $grid = $this->createNewGrid($size);
        $definitions = array_map(static fn (array $item) => $item['word']['definition'], $crossword);
        foreach ($crossword as $index => $line) {
            foreach ($line['line'] as $number => $cell) {
                $grid[$cell['coordinate']]['letter'] = $cell['letter'];
                $this->fillCell($grid[$cell['coordinate']], 'index', $index);
                0 === $number && $this->fillCell($grid[$cell['coordinate']], 'number', $index);
            }
        }

        return new GameDto($grid, $size, $definitions);
    }

    private function fillCell(array &$cell, string $key, int $value): void
    {
        $cell[$key] = array_key_exists($key, $cell) ? $cell[$key] . '/' . ($value + 1) : $value + 1;
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
