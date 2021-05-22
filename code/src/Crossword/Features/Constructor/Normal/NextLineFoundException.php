<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Normal;

use DomainException;
use Throwable;

final class NextLineFoundException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        $message = sprintf('Could not to create generate a next line.');

        parent::__construct($message, 0, $previous);
    }
}
