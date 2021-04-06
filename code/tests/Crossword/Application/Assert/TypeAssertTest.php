<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Application\Assert;

use App\Crossword\Application\Assert\TypeAssert;
use App\Crossword\Domain\Enum\Type;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \App\Crossword\Application\Assert\TypeAssert
 */
final class TypeAssertTest extends TestCase
{
    /**
     * @covers ::assertSupportedType
     */
    public function testRightTypeAssert(): void
    {
        TypeAssert::assertSupportedType(Type::NORMAL);
        TypeAssert::assertSupportedType(Type::FIGURED);

        self::assertTrue(true);
    }

    /**
     * @covers ::assertSupportedType
     */
    public function testWrongTypeAssert(): void
    {
        $this->expectException(RuntimeException::class);

        TypeAssert::assertSupportedType('test');
    }
}
