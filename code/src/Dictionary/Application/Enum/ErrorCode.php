<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class ErrorCode extends Enum
{
    public const WORD_IS_NOT_FOUND = 'Word is not found in the dictionary.';

    public const DICTIONARY_IS_EMPTY = 'Dictionary is empty.';
}
