<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Dto\ErrorDto;

final class ErrorFactory
{
    public static function languageIsNotFound(): ErrorDto
    {
        return new ErrorDto('LANGUAGES_NOT_FOUND', 'Not found any supported languages.');
    }

    public static function crosswordIsNotReceived(): ErrorDto
    {
        return new ErrorDto('CROSSWORD_NOT_RECEIVED', 'Crossword is not received from the storage.');
    }
}
