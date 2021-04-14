<?php

declare(strict_types=1);

namespace App\Game\Domain\Service;

use App\Game\Domain\Exception\NotFoundSupportedLanguagesException;
use App\Game\Domain\Port\CrosswordInterface;
use App\SharedKernel\Infrastructure\HttpClient\Exception\ApiClientException;
use Psr\Log\LoggerInterface;

final class SupportedLanguages
{
    private LoggerInterface $logger;
    private CrosswordInterface $crossword;

    public function __construct(CrosswordInterface $crossword, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->crossword = $crossword;
    }

    /**
     * @throws NotFoundSupportedLanguagesException
     */
    public function languages(): array
    {
        try {
            $languagesDto = $this->crossword->supportedLanguages();

            return $languagesDto->count() ? $languagesDto->languages() : [];
        } catch (ApiClientException $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new NotFoundSupportedLanguagesException();
    }
}
