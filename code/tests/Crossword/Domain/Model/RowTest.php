<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Model;

use App\Crossword\Domain\Exception\CellNotFoundException;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Row;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Model\Row
 */
final class RowTest extends TestCase
{
    /**
     * @covers ::cell
     */
    public function testSearchCellByIndex(): void
    {
        $row = new Row(new Cell(new Coordinate(1, 1), 't'));
        $cell = $row->cell(0);

        self::assertInstanceOf(Cell::class, $cell);
    }

    /**
     * @covers ::remove
     */
    public function testRemoveCellByIndex(): void
    {
        $this->expectException(CellNotFoundException::class);

        $row = new Row(new Cell(new Coordinate(1, 1), 't'));
        $cell = $row->cell(0);

        self::assertInstanceOf(Cell::class, $cell);

        $row = $row->remove(0);
        $row->cell(0);
    }

    /**
     * @covers ::mask
     *
     * @dataProvider maskDataProvider
     */
    public function testBuildMaskByRow(string $mask, string $limit, array $cells): void
    {
        $row = new Row(...$cells);

        self::assertSame($row->mask()->query(), $mask);
        self::assertSame($row->mask()->limit(), $limit);
    }

    public function maskDataProvider(): Generator
    {
        yield '..s' => [
            '..s.*',
            '{0,3}',
            [
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), ''),
                new Cell(new Coordinate(1, 4), 's'),
            ]
        ];

        yield '.s.' => [
            '.s.*',
            '{0,3}',
            [
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), 's'),
                new Cell(new Coordinate(1, 4), ''),
            ]
        ];

        yield '.s..' => [
            '.s.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), 's'),
                new Cell(new Coordinate(1, 4), ''),
                new Cell(new Coordinate(1, 5), ''),
            ]
        ];

        yield '....' => [
            '.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 1), ''),
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), ''),
                new Cell(new Coordinate(1, 4), ''),
            ]
        ];

        yield 'a...' => [
            'a.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 1), 'a'),
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), ''),
                new Cell(new Coordinate(1, 4), ''),
            ]
        ];

        yield '.a.' => [
            '.a.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 1), ''),
                new Cell(new Coordinate(1, 2), 'a'),
                new Cell(new Coordinate(1, 3), ''),
                new Cell(new Coordinate(1, 4), ''),
            ]
        ];

        yield '..a.' => [
            '..a.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 1), ''),
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), 'a'),
                new Cell(new Coordinate(1, 4), ''),
            ]
        ];

        yield 'a..a' => [
            'a..a.*',
            '{0,4}',
            [
                new Cell(new Coordinate(1, 1), 'a'),
                new Cell(new Coordinate(1, 2), ''),
                new Cell(new Coordinate(1, 3), ''),
                new Cell(new Coordinate(1, 4), 'a'),
            ]
        ];
    }
}
