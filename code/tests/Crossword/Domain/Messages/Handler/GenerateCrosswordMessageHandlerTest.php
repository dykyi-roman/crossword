<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Messages\Handler\GenerateCrosswordMessageHandler;
use App\Tests\CrosswordAbstractTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Messages\Handler\GenerateCrosswordMessageHandler
 */
final class GenerateCrosswordMessageHandlerTest extends CrosswordAbstractTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testA(): void
    {
        //todo write a test

        self::assertSame(1,1);
    }
}
