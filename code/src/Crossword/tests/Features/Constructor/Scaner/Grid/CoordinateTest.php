<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Constructor\Scaner\Grid;

use App\Crossword\Features\Constructor\Scanner\Grid\Coordinate;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Constructor\Scanner\Grid\Coordinate
 */
final class CoordinateTest extends TestCase
{
    /**
     * @covers ::left
     */
    public function testLeftShift(): void
    {
        $coordinate = (new Coordinate(1, 2))->left();

        self::assertSame($coordinate->jsonSerialize()['x'], 0);
        self::assertSame($coordinate->jsonSerialize()['y'], 2);
    }

    /**
     * @covers ::right
     */
    public function testRightShift(): void
    {
        $coordinate = (new Coordinate(1, 2))->right();

        self::assertSame($coordinate->jsonSerialize()['x'], 2);
        self::assertSame($coordinate->jsonSerialize()['y'], 2);
    }

    /**
     * @covers ::top
     */
    public function testTopShift(): void
    {
        $coordinate = (new Coordinate(1, 2))->top();

        self::assertSame($coordinate->jsonSerialize()['x'], 1);
        self::assertSame($coordinate->jsonSerialize()['y'], 3);
    }

    /**
     * @covers ::down
     */
    public function testDownShift(): void
    {
        $coordinate = (new Coordinate(1, 2))->down();

        self::assertSame($coordinate->jsonSerialize()['x'], 1);
        self::assertSame($coordinate->jsonSerialize()['y'], 1);
    }

    /**
     * @covers ::inFrame
     */
    public function testInFrameByX(): void
    {
        $coordinate = (new Coordinate(1, 2))->left();

        self::assertFalse($coordinate->inFrame());
    }

    /**
     * @covers ::inFrame
     */
    public function testInFrameByY(): void
    {
        $coordinate = (new Coordinate(2, 1))->down();

        self::assertFalse($coordinate->inFrame());
    }

    /**
     * @covers ::inFrame
     */
    public function testCastToString(): void
    {
        self::assertSame((string) (new Coordinate(2, 1)), '2.1');
    }
}
