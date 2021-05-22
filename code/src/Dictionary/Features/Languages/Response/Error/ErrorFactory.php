<?php

declare(strict_types=1);

namespace App\Dictionary\Features\Languages\Response\Error;

final class ErrorFactory
{
    public static function emptyDictionary(): ErrorCriteria
    {
        return new ErrorCriteria('DICTIONARY_IS_EMPTY', 'Dictionary is empty.');
    }
}
