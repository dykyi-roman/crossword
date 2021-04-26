<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Repository;

use App\Crossword\Domain\Dto\CrosswordDto;
use JsonException;

interface PersistCrosswordRepositoryInterface
{
    /**
     * @throws JsonException
     */
    public function save(string $key, CrosswordDto $crosswordDto): void;
}
