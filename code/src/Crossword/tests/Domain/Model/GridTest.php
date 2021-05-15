<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Model;

use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Model\Grid
 */
final class GridTest extends TestCase
{
    /**
     * @covers ::isEmpty
     */
    public function testGridIsEmpty(): void
    {
        $grid = new Grid();

        self::assertTrue($grid->isEmpty());

        $grid->fillLine(new Line(new Row(new Cell(new Coordinate(1, 2), 'a'))));

        self::assertFalse($grid->isEmpty());
    }

    /**
     * @covers ::fillLine
     */
    public function testFillLineANewCell(): void
    {
        $grid = new Grid();

        $grid->fillLine(new Line(new Row(new Cell(new Coordinate(1, 2), 'a'))));

        self::assertArrayHasKey('1.2', $grid->getIterator()->getArrayCopy());
    }

    /**
     * @covers ::shiftCell
     */
    public function testShiftCellToExistCoordinate(): void
    {
        $row = new Row(
            new Cell(new Coordinate(1, 2), 't'),
            new Cell(new Coordinate(1, 3), 'e'),
            new Cell(new Coordinate(1, 4), 's'),
            new Cell(new Coordinate(1, 5), 't'),
        );
        $grid = new Grid();
        $grid->fillLine(new Line($row));

        $cell = $grid->shiftCell(new Coordinate(1, 4));

        self::assertSame($cell->letter(), 's');
    }

    /**
     * @covers ::shiftCell
     */
    public function testShiftCellToNotExistCoordinate(): void
    {
        $row = new Row(
            new Cell(new Coordinate(1, 2), 't'),
            new Cell(new Coordinate(1, 3), 'e'),
            new Cell(new Coordinate(1, 4), 's'),
            new Cell(new Coordinate(1, 5), 't'),
        );
        $grid = new Grid();
        $grid->fillLine(new Line($row));

        $cell = $grid->shiftCell(new Coordinate(2, 4));

        self::assertTrue($cell->isEmpty());
    }

    /**
     * @covers ::shiftCell
     */
    public function testShiftCellToNotInFrameCoordinate(): void
    {
        $grid = new Grid();
        $grid->fillLine(new Line(new Row(new Cell(new Coordinate(0, 0), 'a'))));

        $cell = $grid->shiftCell(new Coordinate(0, 0));

        self::assertTrue($cell->isEmpty());
    }

    /**
     * @covers ::fillBlackSquare
     *
     * @dataProvider blackSquareDataProvider
     */
    public function testFillBlackSquare(array $blackSquareCoordinates, Row $row): void
    {
        $grid = new Grid();
        $grid->fillLine(new Line($row));

        $array = $grid->getIterator()->getArrayCopy();
        foreach ($blackSquareCoordinates as $coordinate) {
            self::assertTrue($array[(string) $coordinate]->isBlack());
        }
    }

    public function blackSquareDataProvider()
    {
        yield 'Row by X axis' => [
            [
                new Coordinate(1, 1),
                new Coordinate(1, 6)
            ],
            new Row(
                new Cell(new Coordinate(1, 2), 'm'),
                new Cell(new Coordinate(1, 3), 'a'),
                new Cell(new Coordinate(1, 4), 'm'),
                new Cell(new Coordinate(1, 5), 'a'),
            )
        ];

        yield 'Row by Y axis' => [
            [
                new Coordinate(1, 2),
                new Coordinate(6, 2)
            ],
            new Row(
                new Cell(new Coordinate(2, 2), 'm'),
                new Cell(new Coordinate(3, 2), 'a'),
                new Cell(new Coordinate(4, 2), 'm'),
                new Cell(new Coordinate(5, 2), 'a'),
            )
        ];

        yield 'Row by Y axis with out the frame top' => [
            [
                new Coordinate(5, 2),
            ],
            new Row(
                new Cell(new Coordinate(1, 2), 'm'),
                new Cell(new Coordinate(2, 2), 'a'),
                new Cell(new Coordinate(3, 2), 'm'),
                new Cell(new Coordinate(4, 2), 'a'),
            )
        ];

        yield 'Row by X axis with out the frame top' => [
            [
                new Coordinate(2, 5),
            ],
            new Row(
                new Cell(new Coordinate(2, 1), 'm'),
                new Cell(new Coordinate(2, 2), 'a'),
                new Cell(new Coordinate(2, 3), 'm'),
                new Cell(new Coordinate(2, 4), 'a'),
            )
        ];
    }
}
