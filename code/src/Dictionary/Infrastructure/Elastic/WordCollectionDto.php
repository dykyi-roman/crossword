<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Elastic;

final class WordCollectionDto
{
    /**
     * @var WordDto[]
     */
    private array $words;

    public function __construct(array $words)
    {
        $this->words = array_map(fn (array $attributes) => new WordDto($attributes), $words['hits']['hits']);
    }

    public function words(): array
    {
        return $this->words;
    }
}
