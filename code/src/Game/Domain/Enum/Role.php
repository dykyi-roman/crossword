<?php

declare(strict_types=1);

namespace App\Game\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Role extends Enum
{
    public const SIMPLE_PLAYER = 'ROLE_SIMPLE';
    public const PREMIUM_PLAYER = 'ROLE_PREMIUM';
}
