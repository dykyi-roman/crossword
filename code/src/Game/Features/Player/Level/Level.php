<?php

declare(strict_types=1);

namespace App\Game\Features\Player\Level;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
class Level extends Enum
{
    public const LAST_LEVEL = 5;
}
