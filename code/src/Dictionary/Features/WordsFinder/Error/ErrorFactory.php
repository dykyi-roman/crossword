<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Error;

final class ErrorFactory
{
    public static function emptyDictionary(): ErrorDto
    {
        return new ErrorDto('DICTIONARY_IS_EMPTY', 'Dictionary is empty.');
    }

    public static function wordIsNotFound(): ErrorDto
    {
        return new ErrorDto('WORD_IS_NOT_FOUND', 'Word is not found in the dictionary.');
    }
}
