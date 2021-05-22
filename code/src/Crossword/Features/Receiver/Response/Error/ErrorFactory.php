<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver\Response\Error;

final class ErrorFactory
{
    public static function crosswordIsNotReceived(): ErrorCriteria
    {
        return new ErrorCriteria('CROSSWORD_NOT_RECEIVED', 'Crossword is not received from the storage.');
    }
}
