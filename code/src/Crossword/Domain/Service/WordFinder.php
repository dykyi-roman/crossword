<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service;

use App\Crossword\Domain\Criteria\WordSearchCriteria;
use App\Crossword\Domain\Exception\ApiClientException;
use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Port\DictionaryInterface;
use Psr\Log\LoggerInterface;

final class WordFinder
{
    private LoggerInterface $logger;
    private DictionaryInterface $dictionary;

    public function __construct(DictionaryInterface $dictionary, LoggerInterface $logger)
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
