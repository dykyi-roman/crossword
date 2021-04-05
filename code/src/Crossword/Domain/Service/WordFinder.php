<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service;

use App\Crossword\Domain\Exception\WordFoundException;
use App\Crossword\Domain\Model\Word;
use App\Crossword\Domain\Provider\DictionaryProviderInterface;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;
use Psr\Log\LoggerInterface;

final class WordFinder
{
    private LoggerInterface $logger;
    private DictionaryProviderInterface $dictionaryProvider;

    public function __construct(DictionaryProviderInterface $dictionaryProvider, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->dictionaryProvider = $dictionaryProvider;
    }

    public function find(string $language, string $mask): Word
    {
        try {
            $searchWordDto = $this->dictionaryProvider->searchWord($language, $mask);
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
