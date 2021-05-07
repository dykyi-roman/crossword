<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Messages\Message;

use App\SharedKernel\Domain\Model\Word;

/**
 * @psalm-immutable
 *
 * @see SaveToStorageMessageHandler
 */
final class SaveToStorageMessage
{
    private string $word;
    private string $language;
    private string $definition;

    public function __construct(string $word, string $definition, string $language)
    {
        $this->word = $word;
        $this->language = $language;
        $this->definition = $definition;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function word(): Word
    {
        return new Word($this->word, $this->definition);
    }
}
