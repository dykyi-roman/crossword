<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver\Request;

use RuntimeException;

final class RequestException extends RuntimeException
{
    public static function missingRequest(): self
    {
        return new self('Not found current request.');
    }
}
