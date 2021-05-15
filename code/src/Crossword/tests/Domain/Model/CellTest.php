<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Model;

use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Model\Cell
 */
final class CellTest extends TestCase
{
    /**
     * @covers ::letter
     */
    public function testCellFillLetter(): void
    {
        $cell = new Cell(new Coordinate(1, 1), null);
        self::assertNull($cell->letter());

        $cell = Cell::withLetter($cell, 'a');
        self::assertSame('a', $cell->letter());
    }

    /**
     * @covers ::isLetter
     */
    public function testCellIsLetter(): void
    {
        $cell = new Cell(new Coordinate(1, 1), 'a');

        self::assertTrue($cell->isLetter());
        self::assertFalse($cell->isEmpty());
        self::assertFalse($cell->isBlack());
    }

    /**
     * @covers ::isBlack
     */
    public function testCellIsBlack(): void
    {
        $cell = new Cell(new Coordinate(1, 1), '');

        self::assertTrue($cell->isBlack());
        self::assertFalse($cell->isLetter());
        self::assertFalse($cell->isEmpty());
    }

    /**
     * @covers ::isEmpty
     */
    public function testCellIsEmpty(): void
    {
        $cell = new Cell(new Coordinate(1, 1), null);

        self::assertFalse($cell->isBlack());
        self::assertFalse($cell->isLetter());
        self::assertTrue($cell->isEmpty());
    }

    /**
     * @covers ::coordinate
     */
    public function testCoordinateIsJsonSerialized(): void
    {
        $cell = new Cell(new Coordinate(1, 2), null);
        $coordinate = $cell->coordinate()->jsonSerialize();

        self::assertInstanceOf(Coordinate::class, $cell->coordinate());
        self::assertSame(1, $coordinate['x']);
        self::assertSame(2, $coordinate['y']);
    }
}
