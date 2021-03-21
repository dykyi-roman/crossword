<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Provider;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;

interface DictionaryProviderInterface
{
    /**
     * @throws ApiClientException
     */
    public function supportedLanguages(): DictionaryLanguagesDto;
}
