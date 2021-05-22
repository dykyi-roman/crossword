<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Dictionary;

final class WordSearchCriteria
{
    private string $mask;
    private string $language;

    public function __construct(string $language, string $mask)
    {
        $this->language = $language;
        $this->mask = $mask;
    }

    public function mask(): string
    {
        return $this->mask;
    }

    public function language(): string
    {
        return $this->language;
    }
}
