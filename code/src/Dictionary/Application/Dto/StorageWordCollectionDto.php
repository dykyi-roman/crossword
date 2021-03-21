<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Dto;

/**
 * @psalm-immutable
 */
final class StorageWordCollectionDto
{
    /**
     * @psalm-readonly
     *
     * @var StorageWordDto[]
     */
    private array $words;

    public function __construct(array $words)
    {
        $this->words = array_map(static fn (array $attributes) => new StorageWordDto($attributes), $words);
    }

    public function words(): array
    {
        return $this->words;
    }
}
