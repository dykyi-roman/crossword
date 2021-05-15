<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Application\Service;

use App\Crossword\Application\Criteria\GenerateCriteria;
use App\Crossword\Application\Service\CrosswordGenerator;
use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Application\Service\CrosswordGenerator
 */
final class CrosswordGeneratorTest extends CrosswordTestCase
{
    /**
     * @covers ::generate
     */
    public function testSuccessfullyGenerateCrossword(): void
    {
        $response = new SuccessApiResponse(['en']);

        $crosswordGenerator = new CrosswordGenerator(
            new InMemoryDictionaryAdapter(
                new DictionaryLanguagesDto($response->body()),
                null
            ),
            $this->messageBusMockWithConsecutive(
                self::once(),
                new GenerateCrosswordMessage('en', Type::NORMAL, 3)
            )
        );

        $crosswordGenerator->generate(new GenerateCriteria(Type::NORMAL, 3, 1));
    }
}
