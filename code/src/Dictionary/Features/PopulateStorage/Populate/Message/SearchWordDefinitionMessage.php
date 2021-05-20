<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate\Message;

/**
 * @psalm-immutable
 *
 * @see SearchWordDefinitionMessageHandler
 */
final class SearchWordDefinitionMessage
{
    private string $word;
    private string $language;

    public function __construct(string $word, string $language)
    {
        $this->word = $word;
        $this->language = $language;
    }

    public function word(): string
    {
        return $this->word;
    }

    public function language(): string
    {
        return $this->language;
    }
}
