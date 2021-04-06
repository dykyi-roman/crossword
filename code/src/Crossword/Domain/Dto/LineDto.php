<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

use JsonSerializable;

/**
 * @psalm-immutable
 */
final class LineDto implements JsonSerializable
{
    private array $row;
    private array $word;

    public function __construct(array $word, array $row)
    {
        $this->row = $row;
        $this->word = $word;
    }

    public function jsonSerialize(): array
    {
        return [
            'row' => $this->row,
            'word' => $this->word,
        ];
    }
}
