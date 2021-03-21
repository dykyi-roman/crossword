<?php

declare(strict_types=1);

namespace App\Crossword\Application\Assert;

use App\Crossword\Application\Enum\Level;
use RuntimeException;
use Webmozart\Assert\Assert;

final class LevelAssert extends Assert
{
    public static function assertSupportedLevel(int $level): void
    {
        if (!Level::isValid($level)) {
            throw new RuntimeException(sprintf('The level "%d" is not supported.', $level));
        }
    }
}
