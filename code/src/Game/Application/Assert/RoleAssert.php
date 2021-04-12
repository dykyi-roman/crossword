<?php

declare(strict_types=1);

namespace App\Game\Application\Assert;

use App\Game\Domain\Enum\Role;
use RuntimeException;
use Webmozart\Assert\Assert;

final class RoleAssert extends Assert
{
    public static function assertSupportedRole(string $role): void
    {
        if (!Role::isValid($role)) {
            throw new RuntimeException(sprintf('The role "%s" is not supported.', $role));
        }
    }
}
