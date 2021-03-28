<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Model;

use Countable;
use JsonSerializable;

final class WordCollection implements JsonSerializable, Countable
{
    /**
     * @readonly
     * @psalm-allow-private-mutation
     *
     * @var Word[]
     */
    private array $words;

    public function __construct(Word ...$words)
    {
        $this->words = $words;
    }

    public function add(Word $word): void
    {
        $this->words[] = $word;
    }

    public function jsonSerialize(): array
    {
        return array_map(static fn (Word $word) => $words[] = $word->jsonSerialize(), $this->words);
    }

    public function count(): int
    {
        return count($this->words);
    }
}
