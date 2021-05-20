<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Upload;

use App\Dictionary\Features\PopulateStorage\FileReader\FileReaderInterface;
use App\Dictionary\Features\PopulateStorage\SaveStorage\Message\SaveToStorageMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class WordsStorageUpload
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

    public function execute(WordsStorageUploadCriteria $criteria): int
    {
        try {
            return $this->doExecute($criteria);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return 0;
    }

    private function doExecute(WordsStorageUploadCriteria $criteria): int
    {
        $count = 0;
        foreach ($this->fileReader->read($criteria->filePath()) as $row) {
            if ($count) {
                $this->messageBus->dispatch(new SaveToStorageMessage($row[1], $row[2], $row[0]));
            }
            $count++;
        }

        return $count - 1;
    }
}
