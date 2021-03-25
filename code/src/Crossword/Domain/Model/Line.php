<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Line implements JsonSerializable
{
    /**
     * @var Cell[]
     */
    private array $cells;
    private Word $word;
    private int $number;

    public function __construct(int $number, Word $word, Cell ...$cells)
    {
        $this->word = $word;
        $this->cells = $cells;
        $this->number = $number;
    }

    /**
     * @return Cell[]
     */
    public function cells(): array
    {
        return $this->cells;
    }

    public function word(): Word
    {
        return $this->word;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->number,
            'cells' => array_map(static fn (Cell $cell) => $result[] = $cell->jsonSerialize(), $this->cells),
            'word' => $this->word->jsonSerialize(),
        ];
    }
}
