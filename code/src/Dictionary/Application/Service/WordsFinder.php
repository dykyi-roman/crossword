<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Exception\NotFoundWordException;
use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Domain\Dto\WordDtoCollection;
use App\Dictionary\Domain\Exception\WordNotFoundInStorageException;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;
use App\SharedKernel\Domain\Model\Mask;
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

    public function find(string $language, Mask $mask, int $limit): WordDtoCollection
    {
        try {
            return $this->wordsStorage->search($language, $mask, $limit);
        } catch (WordNotFoundInStorageException $exception) {
            $this->logger->error($exception->getMessage());

            throw new NotFoundWordException();
        }
    }
}
