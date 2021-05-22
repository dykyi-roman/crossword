<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver\Type;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Type extends Enum
{
    public const NORMAL = 'normal';
    public const FIGURED = 'figured';

    public static function normal(): self
    {
        return new self(self::NORMAL);
    }

    public static function figure(): self
    {
        return new self(self::FIGURED);
    }
}
