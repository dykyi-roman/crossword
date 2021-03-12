<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Message;

/**
 * @see WordMessageHandler
 */
final class WordMessage
{
    private string $word;

    public function __construct(string $word)
    {
        $this->word = $word;
    }

    public function word(): string
    {
        return $this->word;
    }
}
