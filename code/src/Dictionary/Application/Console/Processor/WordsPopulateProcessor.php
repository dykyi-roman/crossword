<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Console\Processor;

use App\Dictionary\Application\Console\Criteria\WordsPopulateCriteria;
use App\Dictionary\Domain\Messages\Message\WordMessage;
use App\Dictionary\Domain\Service\FileReaderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class WordsPopulateProcessor
{
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

    public function launchByCriteria(WordsPopulateCriteria $criteria): void
    {
        try {
            $this->fileReader->open($criteria->filePath());
            foreach ($this->fileReader->rows() as $row) {
                if (null !== $word = $this->processing($row)) {
                    $this->messageBus->dispatch(new WordMessage($word));
                }
            }
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    private function processing(string $word): ?string
    {
        $word = mb_strtolower(str_replace("\r\n", "", trim($word)));
        if (2 > strlen($word)) {
            return null;
        }

        return $word;
    }
}
