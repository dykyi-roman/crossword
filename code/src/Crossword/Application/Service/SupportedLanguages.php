<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Exception\NotFoundSupportedLanguagesException;
use App\Crossword\Domain\Service\Provider\DictionaryProviderInterface;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;
use Psr\Log\LoggerInterface;

final class SupportedLanguages
{
    private LoggerInterface $logger;
    private DictionaryProviderInterface $dictionaryProvider;

    public function __construct(DictionaryProviderInterface $dictionaryProvider, LoggerInterface $logger)
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
            throw new NotFoundSupportedLanguagesException();
        }
    }
}
