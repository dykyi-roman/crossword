<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Upload;

/**
 * @psalm-immutable
 *
 * @see UploadCommand
 */
final class WordsStorageUploadCriteria
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function filePath(): string
    {
        return $this->filePath;
    }
}
