<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Port\DictionaryInterface;
use App\Dictionary\Application\Service\SupportedLanguages;
use App\Dictionary\Application\Service\WordsFinder;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;
use App\SharedKernel\Domain\Model\Mask;

final class DirectDictionaryAdapter implements DictionaryInterface
{
    private const LIMIT = 100;

    private WordsFinder $wordsFinder;
    private SupportedLanguages $supportedLanguages;

    public function __construct(SupportedLanguages $supportedLanguages, WordsFinder $wordsFinder)
    {
        $this->wordsFinder = $wordsFinder;
        $this->supportedLanguages = $supportedLanguages;
    }

    public function supportedLanguages(): DictionaryLanguagesDto
    {
        $data = new SuccessApiResponse($this->supportedLanguages->receive());

        return new DictionaryLanguagesDto($data->body());
    }

    public function searchWord(string $language, string $mask): DictionaryWordDto
    {
        $words =  $this->wordsFinder->find($language, new Mask($mask), self::LIMIT);
        $data = new SuccessApiResponse($words->jsonSerialize());

        return new DictionaryWordDto($data->body());
    }
}
