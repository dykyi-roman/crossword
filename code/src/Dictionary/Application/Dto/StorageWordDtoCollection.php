<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Dto;

use ArrayIterator;
use IteratorAggregate;

/**
 * @psalm-immutable
 */
final class StorageWordDtoCollection implements IteratorAggregate
{
    /**
     * @var StorageWordDto[]
     */
    private array $words;

    public function __construct(array $words)
    {
        $this->words = array_map(
            static fn (array $attributes): StorageWordDto => new StorageWordDto($attributes),
            $words
        );
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->words);
    }
}
