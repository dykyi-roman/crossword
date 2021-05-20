<?php

declare(strict_types=1);

namespace App\Dictionary\Features\SupportedLanguages;

use App\Dictionary\Features\SupportedLanguages\Storage\LanguageStorageInterface;

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
