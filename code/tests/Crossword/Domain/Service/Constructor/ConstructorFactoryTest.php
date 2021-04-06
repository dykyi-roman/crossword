<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Service\Constructor\ConstructorFactory;
use App\Tests\CrosswordAbstractTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\ConstructorFactory
 */
final class ConstructorFactoryTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::create
     */
    public function testSuccessfullyCreateConstructor(): void
    {
        self::assertSame(1,1);
    }
}
