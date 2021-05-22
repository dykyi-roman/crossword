<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver;

use JsonException;

interface ReadCrosswordRepositoryInterface
{
    /**
     * @throws JsonException | \Psr\Cache\InvalidArgumentException | CrosswordNotFoundException
     */
    public function get(string $key): array;
}
