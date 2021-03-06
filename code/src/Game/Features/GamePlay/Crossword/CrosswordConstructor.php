<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

use Psr\Log\LoggerInterface;

final class CrosswordConstructor
{
    private LoggerInterface $logger;
    private CrosswordInterface $crossword;

    public function __construct(CrosswordInterface $crossword, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->crossword = $crossword;
    }

    /**
     * @throws CrosswordNotConstructedException
     */
    public function construct(CrosswordCriteria $criteria): array
    {
        try {
            $crosswordDto = $this->crossword->construct($criteria);

            return $crosswordDto->count() ? $crosswordDto->crossword() : [];
        } catch (ApiClientException $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new CrosswordNotConstructedException();
    }
}
