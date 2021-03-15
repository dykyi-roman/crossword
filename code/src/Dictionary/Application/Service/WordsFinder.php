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
    private LoggerInterface $logger;
    private WordsStorageInterface $wordsStorage;

    public function __construct(WordsStorageInterface $wordsStorage, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->wordsStorage = $wordsStorage;
    }

    public function findByRequest(WordRequest $request): WordCollection
    {
        try {
            $words = $this->wordsStorage->search($request->language(), $request->mask(), $request->length());
        } catch (WordNotFoundInStorageException $exception) {
            $this->logger->error($exception->getMessage());

            //TODO: Continue to search use foreign API.

            $words = new WordCollection();
        }

        return $words;
    }
}
