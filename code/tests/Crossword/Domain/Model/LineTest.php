<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Model;

use App\Crossword\Domain\Exception\WordNotFitException;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Model\Line
 */
final class LineTest extends TestCase
{
    public function testFillLetter(): void
    {
        $row = new Row(new Cell(new Coordinate(1, 1), null));
        $line = (new Line($row))->fillLetter('q');
        $cells = $line->jsonSerialize();

        self::assertSame($cells[0]['letter'], 'q');

    }

    /**
     * @covers ::fillWord
     */
    public function testThrowException(): void
    {
        $this->expectException(WordNotFitException::class);

        $row = new Row(
            new Cell(new Coordinate(1, 1), null),
            new Cell(new Coordinate(1, 2), null),
            new Cell(new Coordinate(1, 3), null),
            new Cell(new Coordinate(1, 4), 'r'),
            new Cell(new Coordinate(1, 5), null),
            new Cell(new Coordinate(1, 6), null),
            new Cell(new Coordinate(1, 7), null),
        );

        (new Line($row))->fillWord('rest');
    }

    /**
     * @covers ::fillWord
     *
     * @dataProvider rowDataProvider
     */
    public function testFillWord(Row $row): void
    {
        $line = (new Line($row))->fillWord('rest');
        $cells = $line->jsonSerialize();

        self::assertSame($cells[0]['letter'], 'r');
        self::assertSame($cells[1]['letter'], 'e');
        self::assertSame($cells[2]['letter'], 's');
        self::assertSame($cells[3]['letter'], 't');
    }

    public function rowDataProvider(): Generator
    {
        yield '..r.' => [
            new Row(
                new Cell(new Coordinate(1, 1), null),
                new Cell(new Coordinate(1, 2), null),
                new Cell(new Coordinate(1, 3), 'r'),
                new Cell(new Coordinate(1, 4), null),
                new Cell(new Coordinate(1, 5), null),
                new Cell(new Coordinate(1, 6), null),
            )
        ];

        yield '.r..' => [
            new Row(
                new Cell(new Coordinate(1, 1), null),
                new Cell(new Coordinate(1, 2), 'r'),
                new Cell(new Coordinate(1, 3), null),
                new Cell(new Coordinate(1, 4), null),
                new Cell(new Coordinate(1, 5), null),
            )
        ];

        yield 'r...' => [
            new Row(
                new Cell(new Coordinate(1, 1), 'r'),
                new Cell(new Coordinate(1, 2), null),
                new Cell(new Coordinate(1, 3), null),
                new Cell(new Coordinate(1, 4), null),
            )
        ];
    }
}
