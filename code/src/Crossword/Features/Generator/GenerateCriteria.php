<?php

declare(strict_types=1);

namespace App\Crossword\Features\Generator;

/**
 * @psalm-immutable
 *
 * @see GenerateCommand
 */
final class GenerateCriteria
{
    private int $limit;
    private int $wordCount;
    private string $type;
    private string $language;

    public function __construct(string $type, string $language, int $wordCount, int $limit)
    {
        $this->type = $type;
        $this->wordCount = $wordCount;
        $this->limit = $limit;
        $this->language = $language;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function wordCount(): int
    {
        return $this->wordCount;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
