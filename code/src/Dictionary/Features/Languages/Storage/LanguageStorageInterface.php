<?php

declare(strict_types=1);

namespace App\Dictionary\Features\Languages\Storage;

interface LanguageStorageInterface
{
    /**
     * @throws NotFoundSupportedLanguagesException
     */
    public function language(): array;
}
