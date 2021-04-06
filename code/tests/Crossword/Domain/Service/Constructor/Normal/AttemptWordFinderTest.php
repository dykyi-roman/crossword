<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Tests\CrosswordAbstractTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder
 */
final class AttemptWordFinderTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::find
     */
    public function testA(): void
    {
        self::assertSame(1,1);
    }
}
