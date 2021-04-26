<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Repository;

use JsonException;

interface ReadCrosswordRepositoryInterface
{
    /**
     * @throws JsonException | \Psr\Cache\InvalidArgumentException
     */
    public function get(string $key): array;
}
