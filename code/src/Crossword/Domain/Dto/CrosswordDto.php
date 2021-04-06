<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

use JsonSerializable;

/**
 * @psalm-immutable
 */
final class CrosswordDto implements JsonSerializable
{
    /**
     * @var LineDto[]
     */
    private array $lines;

    public function __construct(LineDto ...$lines)
    {
        $this->lines = $lines;
    }

    public function withLine(LineDto $line): self
    {
        return new self($line, ...$this->lines);
    }

    public function jsonSerialize(): array
    {
        return array_map(static fn (LineDto $line) => $line->jsonSerialize(), $this->lines);
    }
}
