<?php

declare(strict_types=1);

namespace App\Game\Application\Enum;

use App\Game\Domain\Enum\Role;

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
