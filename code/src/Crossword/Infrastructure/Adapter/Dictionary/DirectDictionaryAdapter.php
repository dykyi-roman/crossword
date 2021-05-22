<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Features\Constructor\Dictionary\DictionarySearchInterface;
use App\Crossword\Features\Constructor\Dictionary\DictionaryWordDto;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesDto;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesInterface;
use App\Dictionary\Features\Languages\SupportedLanguages;
use App\Dictionary\Features\WordsFinder\WordsFinder;

final class DirectDictionaryAdapter implements DictionaryLanguagesInterface, DictionarySearchInterface
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
