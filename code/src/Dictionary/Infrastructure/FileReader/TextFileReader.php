<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\FileReader;

use App\Dictionary\Domain\Service\FileReaderInterface;
use App\Dictionary\Infrastructure\FileReader\Exception\FileOpenException;
use Generator;

final class TextFileReader implements FileReaderInterface
{
    public function read(string $filePath): Generator
    {
        try {
            $file = fopen($filePath, 'rb');
            if (!$file) {
                throw new FileOpenException($filePath);
            }

            while (!feof($file)) {
                yield fgets($file);
            }
        } finally {
            $file && fclose($file);
        }
    }
}
