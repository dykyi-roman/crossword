<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Word;

use JsonSerializable;

/**
 * @psalm-immutable
 */
final class WordDto implements JsonSerializable
{
    private Word $word;
    private string $language;

    public function __construct(string $language, Word $word)
    {
        $this->word = $word;
        $this->language = $language;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function word(): Word
    {
        return $this->word;
    }

    /**
     * @psalm-suppress ImpureFunctionCall
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            [
                'language' => $this->language,
            ],
            $this->word->jsonSerialize()
        );
    }
}
