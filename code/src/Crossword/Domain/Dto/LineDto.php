<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

use App\Crossword\Domain\Model\Line;
use App\SharedKernel\Domain\Model\Word;
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
