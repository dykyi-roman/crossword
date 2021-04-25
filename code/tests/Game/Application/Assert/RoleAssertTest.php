<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Assert;

use App\Game\Application\Assert\RoleAssert;
use App\Game\Domain\Enum\Role;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Application\Assert\RoleAssert
 */
final class RoleAssertTest extends TestCase
{
    /**
     * @covers ::assertSupportedRole
     */
    public function testRaiseExceptionWhenRoleIsNotSupported(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RoleAssert::assertSupportedRole('test');
    }
    /**
     * @covers ::assertSupportedRole
     */
    public function testWithCorrectAnswer(): void
    {
        RoleAssert::assertSupportedRole(Role::PREMIUM_PLAYER);
        RoleAssert::assertSupportedRole(Role::SIMPLE_PLAYER);

        self::assertTrue(true);
    }
}
