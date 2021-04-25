<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service;

use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\GridScanner;
use App\Tests\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\GridScanner
 */
final class GridScannerTest extends CrosswordTestCase
{
    /**
     * @covers ::fillLine
     */
    public function testSuccessfullyFillGrid(): void
    {
        $grid = new Grid();
        $gridScanner = new GridScanner($grid);

        self::assertTrue($grid->isEmpty());

        $row = new Row(new Cell(new Coordinate(1, 2), 'a'));
        $gridScanner->fillLine(new Line($row));

        self::assertFalse($grid->isEmpty());
    }

    /**
     * @covers ::scanRows
     */
    public function testSuccessfullyScanGrid(): void
    {
        $grid = new Grid();
        $gridScanner = new GridScanner($grid);
        $rows = $gridScanner->scanRows();

        self::assertCount(0, $rows);

        $row = new Row(
            new Cell(new Coordinate(7, 7), 's'),
            new Cell(new Coordinate(10, 7), 't'),
        );
        $gridScanner->fillLine(new Line($row));
        $rows = $gridScanner->scanRows();

        self::assertGreaterThan(1, $rows);
    }
}
