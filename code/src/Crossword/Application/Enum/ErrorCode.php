<?php

declare(strict_types=1);

namespace App\Crossword\Application\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class ErrorCode extends Enum
{
    public const LANGUAGES_NOT_FOUND = 'Not found any supported languages.';

    public const CROSSWORD_NOT_RECEIVED = 'Crossword is not received from the storage.';
}
