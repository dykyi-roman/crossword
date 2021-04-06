<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor\Normal;

use App\Crossword\Domain\Service\Constructor\Normal\NormalConstructor;
use App\Tests\CrosswordAbstractTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\Normal\NormalConstructor
 */
final class NormalConstructorTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::build
     */
    public function testA(): void
    {
        self::assertSame(1,1);
    }
}
