<?php

declare(strict_types=1);

namespace App\Game\Domain\Enum;

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
    public const LEVEL_5 = 5;

    public static function startLevel(): self
    {
        return new self(self::LEVEL_1);
    }

    public static function finishLevel(): self
    {
        return new self(self::LEVEL_5);
    }
}
