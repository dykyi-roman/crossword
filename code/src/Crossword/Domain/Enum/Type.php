<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Enum;

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
}
