<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;
use Stringable;

final class Coordinate implements JsonSerializable, Stringable
{
    private int $coordinateX;
    private int $coordinateY;

    public function __construct(int $coordinateX, int $coordinateY)
    {
        $this->coordinateX = $coordinateX;
        $this->coordinateY = $coordinateY;
    }

    public function inFrame(): bool
    {
        return 0 < $this->coordinateX && 0 < $this->coordinateY;
    }

    public function left(): self
    {
        return new self($this->coordinateX - 1, $this->coordinateY);
    }

    public function right(): self
    {
        return new self($this->coordinateX + 1, $this->coordinateY);
    }

    public function top(): self
    {
        return new self($this->coordinateX, $this->coordinateY + 1);
    }

    public function down(): self
    {
        return new self($this->coordinateX, $this->coordinateY - 1);
    }

    public function jsonSerialize(): array
    {
        return [
            'x' => $this->coordinateX,
            'y' => $this->coordinateY,
        ];
    }

    public function __toString(): string
    {
        return sprintf('%d.%d', $this->coordinateX, $this->coordinateY);
    }
}
