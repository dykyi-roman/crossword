<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Crossword implements JsonSerializable
{
    /**
     * @var Line[]
     */
    private array $lines;

    public function __construct(Line ...$lines)
    {
        $this->lines = $lines;
    }

    public function addLine(Line $line): void
    {
        $this->lines[] = $line;
    }

    public function jsonSerialize(): array
    {
        return array_map(static fn (Line $line) => $result[] = $line->jsonSerialize(), $this->lines);
    }
}
