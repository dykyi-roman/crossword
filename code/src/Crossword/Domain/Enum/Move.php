<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Enum;

use MyCLabs\Enum\Enum;

final class Move extends Enum
{
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const TOP = 'top';
    public const DOWN = 'down';
}
