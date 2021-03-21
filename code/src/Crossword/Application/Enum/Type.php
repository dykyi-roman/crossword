<?php

declare(strict_types=1);

namespace App\Crossword\Application\Enum;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @todo https://wiki.php.net/rfc/enumerations
 */
final class Type extends Enum
{
    public const SIMPLE = 'simple';

    public const FIGURED = 'figured';
}
