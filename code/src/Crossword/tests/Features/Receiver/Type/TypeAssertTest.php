<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Receiver\Type;

use App\Crossword\Features\Receiver\Type\Type;
use App\Crossword\Features\Receiver\Type\TypeAssert;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @coversDefaultClass \App\Crossword\Features\Receiver\Type\TypeAssert
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
