<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

use App\SharedKernel\Domain\Model\Word;
use JsonSerializable;

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
