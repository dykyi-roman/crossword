<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

use App\Game\Features\GamePlay\Player\Role;

final class Type
{
    private const NORMAL = 'normal';
    private const FIGURED = 'figured';

    public static function byRole(Role $role): string
    {
        return match ((string) $role->getValue()) {
            Role::SIMPLE_PLAYER => self::NORMAL,
            Role::PREMIUM_PLAYER => self::FIGURED,
        };
    }
}
