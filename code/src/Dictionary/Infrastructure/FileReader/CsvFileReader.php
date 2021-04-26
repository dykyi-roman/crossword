<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\FileReader;

use App\Dictionary\Domain\Exception\FileOpenException;
use App\Dictionary\Domain\Service\FileReaderInterface;
use Generator;

final class CsvFileReader implements FileReaderInterface
{
    public function read(string $filePath): Generator
    {
        try {
            $file = fopen($filePath, 'rb');
            if (!$file) {
                throw new FileOpenException($filePath);
            }

            while (!feof($file)) {
                yield fgetcsv($file);
            }
        } finally {
            $file && fclose($file);
        }
    }
}
