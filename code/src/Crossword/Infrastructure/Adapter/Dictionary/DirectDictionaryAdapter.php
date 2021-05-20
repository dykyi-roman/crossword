<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Port\DictionaryInterface;
use App\Dictionary\Features\SupportedLanguages\SupportedLanguages;
use App\Dictionary\Features\WordsFinder\WordsFinder;

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
        return new DictionaryLanguagesDto([
            'success' => true,
            'data' => $this->supportedLanguages->languages(),
        ]);
    }

    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto
    {
        $words = $this->wordsFinder->find(
            $criteria->language(),
            $criteria->mask(),
            self::LIMIT
        );

        return new DictionaryWordDto([
            'success' => true,
            'data' => $words->jsonSerialize(),
        ]);
    }
}
