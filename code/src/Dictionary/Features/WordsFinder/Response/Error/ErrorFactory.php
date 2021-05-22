<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Response\Error;

final class ErrorFactory
{
    public static function wordIsNotFound(): ErrorCriteria
    {
        return new ErrorCriteria('WORD_IS_NOT_FOUND', 'Word is not found in the dictionary.');
    }
}
