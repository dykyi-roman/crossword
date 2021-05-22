<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Dictionary;

interface DictionarySearchInterface
{
    /**
     * @throws ApiClientException
     */
    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto;
}
