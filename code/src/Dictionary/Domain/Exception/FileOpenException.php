<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Exception;

use DomainException;

final class FileOpenException extends DomainException
{
    public function __construct(string $filePath)
    {
        $message = sprintf('Failed to open file "%s"', $filePath);

        parent::__construct($message);
    }
}
