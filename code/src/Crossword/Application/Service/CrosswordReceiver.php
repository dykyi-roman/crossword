<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Exception\ReceiveCrosswordException;
use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Repository\ReadCrosswordRepositoryInterface;
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
    public function receive(string $type, string $language, int $wordCount): array
    {
        try {
            $key = sprintf('%s-%s-%d', $language, $type, $wordCount);

            return $this->readCrosswordRepository->get($key);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new ReceiveCrosswordException();
    }
}
