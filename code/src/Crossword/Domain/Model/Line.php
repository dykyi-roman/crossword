<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Model;

use JsonSerializable;

final class Line implements JsonSerializable
{
    private int $number;
    private Word $word;
    private Row $row;

    public function __construct(int $number, Word $word, Row $row)
    {
        $this->row = $row;
        $this->word = $word;
        $this->number = $number;
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->number,
            'row' => $this->row->jsonSerialize(),
            'word' => $this->word->jsonSerialize(),
        ];
    }
}
