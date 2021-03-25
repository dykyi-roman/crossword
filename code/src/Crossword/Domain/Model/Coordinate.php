<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Coordinate implements JsonSerializable
{
    private int $coordinateX;
    private int $coordinateY;

    public function __construct(int $coordinateX, int $coordinateY)
    {
        $this->coordinateX = $coordinateX;
        $this->coordinateY = $coordinateY;
    }

    public function coordinateX(): int
    {
        return $this->coordinateX;
    }

    public function coordinateY(): int
    {
        return $this->coordinateY;
    }

    public function jsonSerialize(): array
    {
        return [
            'x' => $this->coordinateX,
            'y' => $this->coordinateY,
        ];
    }

    public function equals(self $coordinate): bool
    {
        return $coordinate->coordinateX === $this->coordinateX && $coordinate->coordinateY === $this->coordinateY;
    }
}
