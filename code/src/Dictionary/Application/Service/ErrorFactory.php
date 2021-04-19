<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\SharedKernel\Domain\Model\Error;

final class ErrorFactory
{
    public static function emptyDictionary(): Error
    {
        return new Error('DICTIONARY_IS_EMPTY', 'Dictionary is empty.');
    }

    public static function wordIsNotFound(): Error
    {
        return new Error('WORD_IS_NOT_FOUND', 'Word is not found in the dictionary.');
    }
}
