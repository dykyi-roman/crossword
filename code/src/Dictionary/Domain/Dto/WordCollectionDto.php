<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

use App\Dictionary\Domain\Model\Word;
use Countable;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class WordCollectionDto implements JsonSerializable, Countable
{
    /**
     * @var Word[]
     */
    private array $words;

    public function __construct(Word ...$words)
    {
        $this->words = $words;
    }

    public function count(): int
    {
        return count($this->words);
    }

    public function jsonSerialize(): array
    {
        return array_map(static fn (Word $word) => $words[] = $word->jsonSerialize(), $this->words);
    }
}
