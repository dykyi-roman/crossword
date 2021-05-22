<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver;

use Psr\Log\LoggerInterface;
use Throwable;

final class CrosswordReceiver
{
    private LoggerInterface $logger;
    private ReadCrosswordRepositoryInterface $readCrosswordRepository;

    public function __construct(ReadCrosswordRepositoryInterface $readCrosswordRepository, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->readCrosswordRepository = $readCrosswordRepository;
    }

    /**
     * @throws ReceiveCrosswordException
     */
    public function receive(string $key): array
    {
        try {
            return $this->readCrosswordRepository->get($key);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new ReceiveCrosswordException();
    }
}
