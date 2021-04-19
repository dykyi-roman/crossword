<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\SharedKernel\Domain\Model\Error;

final class ErrorFactory
{
    public static function languageIsNotFound(): Error
    {
        return new Error('LANGUAGES_NOT_FOUND', 'Not found any supported languages.');
    }

    public static function crosswordIsNotReceived(): Error
    {
        return new Error('CROSSWORD_NOT_RECEIVED', 'Crossword is not received from the storage.');
    }
}
