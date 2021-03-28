<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Axis extends Enum
{
    public const AXIS_X = 'x';

    public const AXIS_Y = 'y';

    public static function random(): self
    {
        return 1 === random_int(0, 1) ? new self(self::AXIS_X) : new self(self::AXIS_Y);
    }
}
