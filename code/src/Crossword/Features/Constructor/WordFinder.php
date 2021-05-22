<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\Dictionary\ApiClientException;
use App\Crossword\Features\Constructor\Dictionary\DictionarySearchInterface;
use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use Psr\Log\LoggerInterface;

final class WordFinder
{
    private LoggerInterface $logger;
    private DictionarySearchInterface $dictionary;

    public function __construct(DictionarySearchInterface $dictionary, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->dictionary = $dictionary;
    }

    public function search(WordSearchCriteria $criteria): Word
    {
        try {
            $searchWordDto = $this->dictionary->searchWord($criteria);
            if ($searchWordDto->count()) {
                return new Word($searchWordDto->word(), $searchWordDto->definition());
            }

            throw new WordFoundException();
        } catch (ApiClientException $exception) {
            $this->logger->error($exception->getMessage());

            throw new WordFoundException();
        }
    }
}
