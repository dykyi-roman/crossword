<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\FileReader;

use App\Dictionary\Domain\Service\FileReaderInterface;
use Generator;

/**
 * @psalm-suppress MissingConstructor
 */
final class TextFileReader implements FileReaderInterface
{
    /**
     * @var resource
     */
    protected $file;

    public function open(string $filePath): void
    {
        $this->file = fopen($filePath, 'rb');
    }

    public function rows(): Generator
    {
        while (!feof($this->file)) {
            yield fgets($this->file);
        }
    }
}
