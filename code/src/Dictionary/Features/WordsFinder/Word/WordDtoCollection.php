<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Word;

use Countable;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class WordDtoCollection implements JsonSerializable, Countable
{
    /**
     * @var WordDto[]
     */
    private array $words;

    public function __construct(WordDto ...$words)
    {
        $this->words = $words;
    }

    public function count(): int
    {
        return count($this->words);
    }

    /**
     * @psalm-suppress ImpureFunctionCall
     */
    public function jsonSerialize(): array
    {
        return array_map(static fn (WordDto $word) => $word->jsonSerialize(), $this->words);
    }
}
