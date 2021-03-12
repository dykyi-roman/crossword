<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Assert;

use RuntimeException;
use Webmozart\Assert\Assert;

final class FileAssert extends Assert
{
    public static function assertFile(string $filePath): void
    {
        if (!is_file($filePath)) {
            throw new RuntimeException(sprintf('File "%s" is not found.', $filePath));
        }
    }

    public static function assertTxtFile(string $filePath): void
    {
        static::assertFile($filePath);

        if ('txt' !== pathinfo($filePath, PATHINFO_EXTENSION)) {
            throw new RuntimeException(sprintf('File "%s" is not supported. Use a *.txt files.', $filePath));
        }
    }
}
