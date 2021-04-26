<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Exception\NotFoundSupportedLanguagesException;
use App\Crossword\Domain\Exception\ApiClientException;
use App\Crossword\Domain\Port\DictionaryInterface;
use Psr\Log\LoggerInterface;

final class SupportedLanguages
{
    private LoggerInterface $logger;
    private DictionaryInterface $dictionaryProvider;

    public function __construct(DictionaryInterface $dictionaryProvider, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->dictionaryProvider = $dictionaryProvider;
    }

    /**
     * @throws NotFoundSupportedLanguagesException
     */
    public function receive(): array
    {
        try {
            $languages = $this->dictionaryProvider->supportedLanguages();

            return $languages->count() ? $languages->languages() : throw new NotFoundSupportedLanguagesException();
        } catch (ApiClientException $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new NotFoundSupportedLanguagesException();
    }
}
