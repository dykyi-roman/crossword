<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Dto\LanguagesDto;
use App\Game\Domain\Exception\ApiClientException;
use App\Game\Domain\Port\CrosswordInterface;

final class InMemoryCrosswordAdapter implements CrosswordInterface
{
    private null | CrosswordDto $crosswordDto;
    private null | LanguagesDto $languagesDto;

    public function __construct(null | CrosswordDto $crosswordDto, null | LanguagesDto $languagesDto)
    {
        $this->crosswordDto = $crosswordDto;
        $this->languagesDto = $languagesDto;
    }

    public function construct(string $language, string $type, int $wordCount): CrosswordDto
    {
        if (null === $this->crosswordDto) {
            throw ApiClientException::badRequest('test error message');
        }

        return $this->crosswordDto;
    }

    public function supportedLanguages(): LanguagesDto
    {
        if (null === $this->languagesDto) {
            throw ApiClientException::badRequest('test error message');
        }
        return $this->languagesDto;
    }
}
