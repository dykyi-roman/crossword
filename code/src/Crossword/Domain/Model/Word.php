<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Word implements JsonSerializable
{
    private string $value;
    private string $definition;

    public function __construct(string $value, string $definition)
    {
        $this->value = $value;
        $this->definition = $definition;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function definition(): string
    {
        return $this->definition;
    }

    public function jsonSerialize(): array
    {
        return [
            'word' => $this->value,
            'definition' => $this->definition,
        ];
    }
}
