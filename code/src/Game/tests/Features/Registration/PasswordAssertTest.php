<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Registration;

use App\Game\Features\Registration\PasswordAssert;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\Registration\PasswordAssert
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
