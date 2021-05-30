<?php

declare(strict_types=1);

namespace App\Game\Features\History\Response\Error;

final class ErrorFactory
{
    public static function languageIsNotFound(): ErrorCriteria
    {
        return new ErrorCriteria('LANGUAGES_NOT_FOUND', 'Not found any supported languages.');
    }
}
