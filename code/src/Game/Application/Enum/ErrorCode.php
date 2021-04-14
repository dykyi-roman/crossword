<?php

declare(strict_types=1);

namespace App\Game\Application\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class ErrorCode extends Enum
{
    public const LOGIN_FAILED = 'Login failed';
}
