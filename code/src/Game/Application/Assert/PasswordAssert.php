<?php

declare(strict_types=1);

namespace App\Game\Application\Assert;

use RuntimeException;
use Webmozart\Assert\Assert;

final class PasswordAssert
{
    public static function assertValidPassword(string $password): void
    {
        Assert::lessThan($password, 6);

        if (!preg_match("#[0-9]+#", $password)) {
            throw new RuntimeException('Must Contain At Least 1 Number.');
        }
    }
}
