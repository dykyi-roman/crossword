<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Domain\Service\WordsStorageInterface;

final class SupportedLanguages
{
    private WordsStorageInterface $wordsStorage;

    public function __construct(WordsStorageInterface $wordsStorage)
    {
        $this->wordsStorage = $wordsStorage;
    }

    public function list(): array
    {
        return $this->wordsStorage->language();
    }
}
