<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\FileReader\Exception;

use RuntimeException;

final class FileOpenException extends RuntimeException
{
    public function __construct(string $filePath)
    {
        $message = sprintf('Failed to open file "%s"', $filePath);

        parent::__construct($message);
    }
}
