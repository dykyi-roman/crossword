<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Provider;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;

interface DictionaryProviderInterface
{
    /**
     * @throws ApiClientException
     */
    public function supportedLanguages(): DictionaryLanguagesDto;

    /**
     * @throws ApiClientException
     */
    public function searchWord(string $language, string $mask): DictionaryWordDto;
}
