<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Domain\Exception\WordNotFoundInStorageException;
use App\Dictionary\Domain\Model\WordCollection;
use App\Dictionary\Domain\Service\WordsStorageInterface;
use Psr\Log\LoggerInterface;

final class WordsFinder
{
    private WordsStorageInterface $wordsStorage;
    private LoggerInterface $logger;

    public function __construct(WordsStorageInterface $wordsStorage, LoggerInterface $logger)
    {
        $this->wordsStorage = $wordsStorage;
        $this->logger = $logger;
    }

    public function findByRequest(WordRequest $request): WordCollection
    {
        try {
            $words = $this->wordsStorage->find($request->language(), $request->mask(), $request->length());
        } catch (WordNotFoundInStorageException $exception) {
            $this->logger->error($exception->getMessage());

            //todo .. search use API snake calls
            $words = new WordCollection();
        }

        return $words;
    }
}
