<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Word implements JsonSerializable
{
    private string $word;
    private string $definition;

    public function __construct(string $word, string $definition)
    {
        $this->word = $word;
        $this->definition = $definition;
    }

    public function word(): string
    {
        return $this->word;
    }

    public function definition(): string
    {
        return $this->definition;
    }

    public function jsonSerialize(): array
    {
        return [
            'word' => $this->word,
            'definition' => $this->definition,
        ];
    }
}
