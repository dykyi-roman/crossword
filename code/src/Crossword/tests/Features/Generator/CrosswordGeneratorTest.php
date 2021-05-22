<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Generator;

use App\Crossword\Features\Constructor\Message\GenerateCrosswordMessage;
use App\Crossword\Features\Generator\CrosswordGenerator;
use App\Crossword\Features\Generator\GenerateCriteria;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Generator\CrosswordGenerator
 */
final class CrosswordGeneratorTest extends CrosswordTestCase
{
    /**
     * @covers ::generate
     */
    public function testSuccessfullyGenerateCrossword(): void
    {
        $crosswordGenerator = new CrosswordGenerator(
            $this->messageBusMockWithConsecutive(
                self::once(),
                new GenerateCrosswordMessage('en', 'normal', 3)
            )
        );

        $crosswordGenerator->generate(new GenerateCriteria('normal', 'en', 3, 1));
    }
}
