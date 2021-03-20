<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;

final class SupportedLanguages
{
    private ReadWordsStorageInterface $wordsStorage;

    public function __construct(ReadWordsStorageInterface $readWordsStorage)
    {
        $this->wordsStorage = $readWordsStorage;
    }

    public function list(): array
    {
        return $this->wordsStorage->language();
    }
}
