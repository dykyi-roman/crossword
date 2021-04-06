<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Provider;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Service\Provider\DictionaryProviderInterface;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;

final class InMemoryDictionaryProvider implements DictionaryProviderInterface
{
    private ?DictionaryLanguagesDto $languagesDto;
    private ?DictionaryWordDto $wordDto;

    public function __construct(?DictionaryLanguagesDto $languagesDto, ?DictionaryWordDto $wordDto)
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

    public function searchWord(string $language, string $mask): DictionaryWordDto
    {
        if (null === $this->wordDto) {
            throw ApiClientException::badRequest('test error message');
        }

        return $this->wordDto;
    }
}
