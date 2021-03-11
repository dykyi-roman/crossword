<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Elastic;

final class WordDto
{
    private array $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function language(): string
    {
        return $this->attributes['_index'];
    }

    public function word(): string
    {
        return $this->attributes['_source']['word'];
    }

    public function definition(): string
    {
        return $this->attributes['_source']['definition'];
    }
}
