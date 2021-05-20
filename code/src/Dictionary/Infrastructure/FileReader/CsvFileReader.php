<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\FileReader;

use App\Dictionary\Features\PopulateStorage\FileReader\FileReaderInterface;
use App\Dictionary\Features\PopulateStorage\FileReader\OpenFileException;
use Generator;

final class CsvFileReader implements FileReaderInterface
{
    public function read(string $filePath): Generator
    {
        try {
            $file = fopen($filePath, 'rb');
            if (!$file) {
                throw new OpenFileException($filePath);
            }

            while (!feof($file)) {
                yield fgetcsv($file);
            }
        } finally {
            $file && fclose($file);
        }
    }
}
