<?php

declare(strict_types=1);

namespace App\Dictionary\Features\Languages;

use App\Dictionary\Features\Languages\Storage\LanguageStorageInterface;

final class SupportedLanguages
{
    private LanguageStorageInterface $readWordsStorage;

    public function __construct(LanguageStorageInterface $readWordsStorage)
    {
        $this->readWordsStorage = $readWordsStorage;
    }

    public function languages(): array
    {
        return $this->readWordsStorage->language();
    }
}
