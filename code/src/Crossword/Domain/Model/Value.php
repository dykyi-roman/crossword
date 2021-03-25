<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

final class Value
{
    private ?int $value1;
    private ?int $value2;

    public function __construct(int $value1 = null, int $value2 = null)
    {
        $this->value1 = $value1;
        $this->value2 = $value2;
    }

    public function isEmpty(): bool
    {
        return null === $this->getValue1() && null === $this->getValue2();
    }

    public function getValue1(): ?int
    {
        return $this->value1;
    }

    public function getValue2(): ?int
    {
        return $this->value2;
    }
}
