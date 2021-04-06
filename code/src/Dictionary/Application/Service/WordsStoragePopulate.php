<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Criteria\WordsStoragePopulateCriteria;
use App\Dictionary\Domain\Messages\Message\SearchWordDefinitionMessage;
use App\Dictionary\Domain\Service\FileReaderInterface;
use App\Dictionary\Infrastructure\FileReader\TextFileReader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class WordsStoragePopulate
{
    private const MIN_WORD_LENGTH = 3;

    private LoggerInterface $logger;
    private FileReaderInterface $fileReader;
    private MessageBusInterface $messageBus;

    public function __construct(
        TextFileReader $fileReader,
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->fileReader = $fileReader;
        $this->messageBus = $messageBus;
    }

    public function execute(WordsStoragePopulateCriteria $criteria): int
    {
        try {
            return $this->doExecute($criteria);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return 0;
    }

    private function doExecute(WordsStoragePopulateCriteria $criteria): int
    {
        $count = 0;
        foreach ($this->fileReader->read($criteria->filePath()) as $row) {
            if (null !== $word = $this->wordProcessing((string) $row)) {
                $this->messageBus->dispatch(new SearchWordDefinitionMessage($word, $criteria->language()));
                $count++;
            }
        }

        return $count;
    }

    private function wordProcessing(string $word): ?string
    {
        $word = mb_strtolower(str_replace('\r\n', '', trim($word)));
        if (strlen($word) < self::MIN_WORD_LENGTH) {
            return null;
        }

        return $word;
    }
}
