<?php

declare(strict_types=1);

namespace App\Game\Features\Registration\Role;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class RoleAssert extends Assert
{
    /**
     * @throws InvalidArgumentException
     */
    public static function assertSupportedRole(string $role): void
    {
        if (!Role::isValid($role)) {
            throw new InvalidArgumentException(sprintf('The role "%s" is not supported.', $role));
        }
    }
}
