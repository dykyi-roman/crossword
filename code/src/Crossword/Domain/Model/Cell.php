<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Cell implements JsonSerializable
{
    private ?string $letter;
    private Coordinate $coordinate;

    public function __construct(Coordinate $coordinate, ?string $letter)
    {
        $this->coordinate = $coordinate;
        $this->letter = $letter;
    }

    public function coordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function left(): Coordinate
    {
        return new Coordinate($this->coordinate->coordinateX() - 1, $this->coordinate()->coordinateY());
    }

    public function right(): Coordinate
    {
        return new Coordinate($this->coordinate->coordinateX() + 1, $this->coordinate()->coordinateY());
    }

    public function top(): Coordinate
    {
        return new Coordinate($this->coordinate->coordinateX(), $this->coordinate()->coordinateY() + 1);
    }

    public function down(): Coordinate
    {
        return new Coordinate($this->coordinate->coordinateX(), $this->coordinate()->coordinateY() - 1);
    }

    public function isLetter(): bool
    {
        return !empty($this->letter);
    }

    public function letter(): ?string
    {
        return $this->letter;
    }

    public function fill(string $letter): void
    {
        $this->letter = $letter;
    }

    public function jsonSerialize(): array
    {
        return [
            'letter' => $this->letter,
            'coordinate' => $this->coordinate->jsonSerialize(),
        ];
    }
}
