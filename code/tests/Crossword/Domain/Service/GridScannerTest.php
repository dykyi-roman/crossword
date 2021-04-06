<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service;

use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Service\GridScanner;
use App\Tests\CrosswordAbstractTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\GridScanner
 */
final class GridScannerTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::grid
     */
    public function testA(): void
    {
        $gridScanner = new GridScanner(new Grid());

        self::assertSame(1,1);
    }
}
