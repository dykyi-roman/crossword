<?php

declare(strict_types=1);

namespace App\Game\Domain\Criteria;

final class CrosswordCriteria
{
    private string $type;
    private int $wordCount;
    private string $language;

    public function __construct(string $language, string $type, int $wordCount)
    {
        $this->type = $type;
        $this->language = $language;
        $this->wordCount = $wordCount;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function wordCount(): int
    {
        return $this->wordCount;
    }
}
