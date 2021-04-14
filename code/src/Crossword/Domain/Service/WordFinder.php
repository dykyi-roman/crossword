<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service;

use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Port\DictionaryInterface;
use App\SharedKernel\Domain\Model\Word;
use App\SharedKernel\Infrastructure\HttpClient\Exception\ApiClientException;
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

    public function find(string $language, string $mask): Word
    {
        try {
            $searchWordDto = $this->dictionary->searchWord($language, $mask);
            if ($searchWordDto->isSuccess()) {
                return new Word($searchWordDto->word(), $searchWordDto->definition());
            }

            throw new WordFoundException();
        } catch (ApiClientException $exception) {
            $this->logger->error($exception->getMessage());

            throw new WordFoundException();
        }
    }
}
