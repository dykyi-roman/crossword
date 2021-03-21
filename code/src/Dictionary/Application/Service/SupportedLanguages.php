<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Exception\NotFoundSupportedLanguagesException;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;

final class SupportedLanguages
{
    private ReadWordsStorageInterface $wordsStorage;

    public function __construct(ReadWordsStorageInterface $readWordsStorage)
    {
        $this->wordsStorage = $readWordsStorage;
    }

    /**
     * @throws NotFoundSupportedLanguagesException
     */
    public function receive(): array
    {
        $languages = $this->wordsStorage->language();

        return count($languages) ? $languages : throw new NotFoundSupportedLanguagesException();
    }
}
