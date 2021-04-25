<?php

declare(strict_types=1);

namespace App\Game\Application\Assert;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class PasswordAssert extends Assert
{
    /**
     * @throws InvalidArgumentException
     */
    public static function assertValidPassword(string $password): void
    {
        self::lessThan($password, 6);

        if (!preg_match("#[0-9]+#", $password)) {
            throw new InvalidArgumentException('Must Contain At Least 1 Number.');
        }
    }
}
