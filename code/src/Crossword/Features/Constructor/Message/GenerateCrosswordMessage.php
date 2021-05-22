<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Message;

/**
 * @see GenerateCrosswordMessageHandler
 */
final class GenerateCrosswordMessage
{
    private int $wordCount;
    private string $type;
    private string $language;

    public function __construct(string $language, string $type, int $wordCount)
    {
        $this->type = $type;
        $this->language = $language;
        $this->wordCount = $wordCount;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function wordCount(): int
    {
        return $this->wordCount;
    }

    public function language(): string
    {
        return $this->language;
    }
}
