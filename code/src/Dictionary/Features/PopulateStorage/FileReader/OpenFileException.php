<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\FileReader;

use DomainException;

final class OpenFileException extends DomainException
{
    public function __construct(string $filePath)
    {
        $message = sprintf('Failed to open file "%s"', $filePath);

        parent::__construct($message);
    }
}
