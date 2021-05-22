<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor;

use JsonException;

interface PersistCrosswordRepositoryInterface
{
    /**
     * @throws JsonException
     */
    public function save(string $key, CrosswordDto $crosswordDto): void;
}
