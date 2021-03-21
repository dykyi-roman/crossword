<?php

declare(strict_types=1);

namespace App\Crossword\Application\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Level extends Enum
{
    public const LEVEL_1 = 1;
    public const LEVEL_2 = 2;
    public const LEVEL_3 = 3;
    public const LEVEL_4 = 4;
}
