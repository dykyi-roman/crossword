<?php

declare(strict_types=1);

namespace Tests\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Service\Constructor\ConstructorFactory;
use App\Crossword\Domain\Service\Constructor\Figured\FiguredConstructor;
use App\Crossword\Domain\Service\Constructor\Normal\NormalConstructor;
use App\Crossword\Domain\Service\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\Tests\Crossword\CrosswordTestCase;
use Generator;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Domain\Service\Constructor\ConstructorFactory
 */
final class ConstructorFactoryTest extends CrosswordTestCase
{
    /**
     * @covers ::create
     *
     * @dataProvider typesDataProvider
     */
    public function testSuccessfullyCreateConstructor(Type $type, string $result): void
    {
        $wordFinder = new WordFinder(new InMemoryDictionaryAdapter(null, null), new NullLogger());
        $factory = new ConstructorFactory($wordFinder);
        $class = $factory->create($type);

        self::assertInstanceOf($result, $class);
    }

    public function typesDataProvider(): Generator
    {
        yield 'Create normal constructor' => [Type::normal(), NormalConstructor::class];
        yield 'Create figure constructor' => [Type::figure(), FiguredConstructor::class];
    }
}
