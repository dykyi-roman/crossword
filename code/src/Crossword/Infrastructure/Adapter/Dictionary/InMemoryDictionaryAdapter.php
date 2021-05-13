<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Exception\ApiClientException;
use App\Crossword\Domain\Port\DictionaryInterface;

final class InMemoryDictionaryAdapter implements DictionaryInterface
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
            throw ApiClientException::badRequest('test error message');
        }

        return $this->languagesDto;
    }

    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto
    {
        if (null === $this->wordDto) {
            throw ApiClientException::badRequest('test error message');
        }

        return $this->wordDto;
    }
}
