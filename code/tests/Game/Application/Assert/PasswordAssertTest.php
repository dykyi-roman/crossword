<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Assert;

use App\Game\Application\Assert\PasswordAssert;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Application\Assert\PasswordAssert
 */
final class PasswordAssertTest extends TestCase
{
    /**
     * @covers ::assertValidPassword
     */
    public function testWithEmptyPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PasswordAssert::assertValidPassword('');
    }

    /**
     * @covers ::assertValidPassword
     */
    public function testRaiseExceptionWhenPasswordIsNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PasswordAssert::assertValidPassword('12345');
    }

    /**
     * @covers ::assertValidPassword
     */
    public function testWithCorrectPasswordValidation(): void
    {
        PasswordAssert::assertValidPassword('1q2w3e4r');

        self::assertTrue(true);
    }
}
