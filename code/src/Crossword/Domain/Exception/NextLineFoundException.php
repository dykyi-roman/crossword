<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Exception;

use DomainException;
use Throwable;

final class NextLineFoundException extends DomainException
{
    public function __construct(int $lines, Throwable $previous = null)
    {
        $message = sprintf('Could not to create crossword on the %s lines', $lines);

        parent::__construct($message, 0, $previous);
    }
}
