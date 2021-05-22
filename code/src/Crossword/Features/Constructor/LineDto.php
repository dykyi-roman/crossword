<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\Scanner\Grid\Line;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class LineDto implements JsonSerializable
{
    private Line $line;
    private Word $word;

    public function __construct(Line $line, Word $word)
    {
        $this->line = $line;
        $this->word = $word;
    }

    public function line(): Line
    {
        return $this->line;
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function jsonSerialize(): array
    {
        return [
            'line' => $this->line->jsonSerialize(),
            'word' => $this->word->jsonSerialize(),
        ];
    }
}
