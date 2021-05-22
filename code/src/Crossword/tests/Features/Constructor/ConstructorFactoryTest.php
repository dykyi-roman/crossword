<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\ConstructorFactory;
use App\Crossword\Features\Constructor\Figured\FiguredConstructor;
use App\Crossword\Features\Constructor\Normal\NormalConstructor;
use App\Crossword\Features\Constructor\Type\Type;
use App\Crossword\Features\Constructor\WordFinder;
use App\Crossword\Infrastructure\Adapter\Dictionary\InMemoryDictionaryAdapter;
use App\Tests\Crossword\CrosswordTestCase;
use Generator;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Features\Constructor\Figured\FiguredConstructor
 */
final class ConstructorFactoryTest extends CrosswordTestCase
{
    /**
     * @covers ::build
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
