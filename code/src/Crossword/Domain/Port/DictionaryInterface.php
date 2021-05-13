<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Port;

use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Exception\ApiClientException;

interface DictionaryInterface
{
    /**
     * @throws ApiClientException
     */
    public function supportedLanguages(): DictionaryLanguagesDto;

    /**
     * @throws ApiClientException
     */
    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto;
}
