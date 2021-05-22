<?php

declare(strict_types=1);

namespace App\Crossword\Features\Languages\Dictionary;

interface DictionaryLanguagesInterface
{
    /**
     * @throws ApiClientException
     */
    public function supportedLanguages(): DictionaryLanguagesDto;
}
