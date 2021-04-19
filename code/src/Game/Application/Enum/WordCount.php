<?php

declare(strict_types=1);

namespace App\Game\Application\Enum;

use App\Game\Domain\Enum\Level;

final class WordCount
{
    public static function byLevel(Level $level): int
    {
        return match ((int) $level->getValue()) {
            Level::LEVEL_1 => 3,
            Level::LEVEL_2 => 6,
            Level::LEVEL_3 => 9,
            Level::LEVEL_4 => 12,
            Level::LEVEL_5 => 15,
        };
    }
}
