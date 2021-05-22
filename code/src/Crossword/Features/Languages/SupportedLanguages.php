<?php

declare(strict_types=1);

namespace App\Crossword\Features\Languages;

use App\Crossword\Features\Languages\Dictionary\ApiClientException;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesInterface;
use Psr\Log\LoggerInterface;

final class SupportedLanguages
{
    private LoggerInterface $logger;
    private DictionaryLanguagesInterface $dictionaryProvider;

    public function __construct(DictionaryLanguagesInterface $dictionaryProvider, LoggerInterface $logger)
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
