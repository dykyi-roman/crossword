<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Dto\WordsStoragePopulateCriteria;
use App\Dictionary\Domain\Messages\Message\WordMessage;
use App\Dictionary\Domain\Service\FileReaderInterface;
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
        FileReaderInterface $fileReader,
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->fileReader = $fileReader;
        $this->messageBus = $messageBus;
    }

    public function execute(WordsStoragePopulateCriteria $criteria): int
    {
        $count = 0;
        try {
            $this->fileReader->open($criteria->filePath());
            foreach ($this->fileReader->rows() as $row) {
                if (null !== $word = $this->wordProcessing($row)) {
                    $this->messageBus->dispatch(new WordMessage($word, $criteria->language()));
                    $count++;
                }
            }
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $count;
    }

    private function wordProcessing(string $word): ?string
    {
        $word = mb_strtolower(str_replace("\r\n", "", trim($word)));
        if (self::MIN_WORD_LENGTH > strlen($word)) {
            return null;
        }

        return $word;
    }
}
