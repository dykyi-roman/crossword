<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Features\Constructor\Dictionary\ApiClientException as ConstructorApiClientException;
use App\Crossword\Features\Constructor\Dictionary\DictionarySearchInterface;
use App\Crossword\Features\Constructor\Dictionary\DictionaryWordDto;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use App\Crossword\Features\Languages\Dictionary\ApiClientException as LanguagesApiClientException;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesDto;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesInterface;

final class InMemoryDictionaryAdapter implements DictionaryLanguagesInterface, DictionarySearchInterface
{
    private null | DictionaryLanguagesDto $languagesDto;
    private null | DictionaryWordDto $wordDto;

    public function __construct(null | DictionaryLanguagesDto $languagesDto, null | DictionaryWordDto $wordDto)
    {
        $this->languagesDto = $languagesDto;
        $this->wordDto = $wordDto;
    }

    public function supportedLanguages(): DictionaryLanguagesDto
    {
        if (null === $this->languagesDto) {
            throw LanguagesApiClientException::badRequest('test error message');
        }

        return $this->languagesDto;
    }

    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto
    {
        if (null === $this->wordDto) {
            throw ConstructorApiClientException::badRequest('test error message');
        }

        return $this->wordDto;
    }
}
