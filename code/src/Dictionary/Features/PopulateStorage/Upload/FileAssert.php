<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Upload;

use RuntimeException;
use Webmozart\Assert\Assert;

final class FileAssert extends Assert
{
    /**
     * @throws RuntimeException
     */
    public static function assertFile(string $filePath): void
    {
        if (!is_file($filePath)) {
            throw new RuntimeException(sprintf('The file "%s" is not found.', $filePath));
        }
    }

    /**
     * @throws RuntimeException
     */
    public static function assertCsvFile(string $filePath): void
    {
        self::assertFile($filePath);

        if ('csv' !== pathinfo($filePath, PATHINFO_EXTENSION)) {
            throw new RuntimeException(sprintf('The file "%s" is not supported. Use a *.csv files.', $filePath));
        }
    }
}
