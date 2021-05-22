<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Scanner;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Move extends Enum
{
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const TOP = 'top';
    public const DOWN = 'down';
}
