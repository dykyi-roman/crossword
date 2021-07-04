<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Application\Dto\GameDto;
use App\Game\Domain\Criteria\CrosswordCriteria;
use App\Game\Domain\Model\Grid;
use App\Game\Domain\Service\CrosswordConstructor;

final class GamePlay
{
    private CrosswordConstructor $constructor;

    public function __construct(CrosswordConstructor $constructor)
    {
        $this->constructor = $constructor;
    }

    public function new(string $language, string $type, int $wordCount): GameDto
    {
        $crossword = $this->constructor->construct(new CrosswordCriteria($language, $type, $wordCount));
        $grid = new Grid($crossword);
        $definitions = array_map(static fn (array $item): string => $item['word']['definition'], $crossword);
        foreach ($crossword as $index => $line) {
            foreach ($line['line'] as $number => $cell) {
                $grid->fillLetter($cell);
                $grid->fillCrossLineNumbers($cell, $index);
                0 === $number && $grid->fillLineNumbers($cell, $index);
            }
        }

        return new GameDto($grid->field(), $grid->size(), $definitions);
    }
}
