<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Exception\NotFoundWordException;
use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Domain\Dto\WordsCollectionDto;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;
use Psr\Log\LoggerInterface;

final class WordsFinder
{
    private LoggerInterface $logger;
    private ReadWordsStorageInterface $wordsStorage;

    public function __construct(ReadWordsStorageInterface $readWordsStorage, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->wordsStorage = $readWordsStorage;
    }

    public function findByRequest(WordRequest $wordRequest): WordsCollectionDto
    {
        try {
            return $this->wordsStorage->search($wordRequest->language(), $wordRequest->mask(), $wordRequest->limit());
        } catch (WordNotFoundInStorageException $exception) {
            $this->logger->error($exception->getMessage());

            throw new NotFoundWordException();
        }
    }
}
