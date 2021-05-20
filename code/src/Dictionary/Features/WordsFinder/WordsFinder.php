<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder;

use App\Dictionary\Features\WordsFinder\Mask\Mask;
use App\Dictionary\Features\WordsFinder\Storage\ReadWordsStorageInterface;
use App\Dictionary\Features\WordsFinder\Storage\WordNotFoundInStorageException;
use App\Dictionary\Features\WordsFinder\Word\WordDtoCollection;
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

    public function find(string $language, string $mask, int $limit): WordDtoCollection
    {
        try {
            return $this->wordsStorage->search($language, new Mask($mask), $limit);
        } catch (WordNotFoundInStorageException $exception) {
            $this->logger->error($exception->getMessage());

            throw new NotFoundWordException();
        }
    }
}
