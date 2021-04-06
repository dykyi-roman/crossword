<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Exception\ReceiveCrosswordException;
use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Enum\Type;
use Psr\Log\LoggerInterface;

final class CrosswordReceiver
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws ReceiveCrosswordException
     */
    public function receive(Type $type, string $language, int $wordCount): CrosswordDto
    {
        try {
            //todo get crossword from the storage
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new ReceiveCrosswordException();
    }
}
