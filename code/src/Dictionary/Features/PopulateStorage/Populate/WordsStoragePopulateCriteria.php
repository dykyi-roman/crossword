<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate;

/**
 * @psalm-immutable
 *
 * @see PopulateCommand
 */
final class WordsStoragePopulateCriteria
{
    private string $language;
    private string $filePath;

    public function __construct(string $language, string $filePath)
    {
        $this->language = $language;
        $this->filePath = $filePath;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function filePath(): string
    {
        return $this->filePath;
    }
}
