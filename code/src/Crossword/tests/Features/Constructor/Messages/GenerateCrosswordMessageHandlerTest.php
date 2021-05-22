<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Constructor\Messages;

use App\Crossword\Features\Constructor\ConstructorFactory;
use App\Crossword\Features\Constructor\ConstructorInterface;
use App\Crossword\Features\Constructor\CrosswordDto;
use App\Crossword\Features\Constructor\Dictionary\Word;
use App\Crossword\Features\Constructor\LineDto;
use App\Crossword\Features\Constructor\Message\GenerateCrosswordMessage;
use App\Crossword\Features\Constructor\Message\GenerateCrosswordMessageHandler;
use App\Crossword\Features\Constructor\Scanner\Grid\Cell;
use App\Crossword\Features\Constructor\Scanner\Grid\Coordinate;
use App\Crossword\Features\Constructor\Scanner\Grid\Line;
use App\Crossword\Features\Constructor\Scanner\Grid\Row;
use App\Crossword\Features\Constructor\Type\Type;
use App\Crossword\Infrastructure\Cache\InMemoryClient;
use App\Crossword\Infrastructure\Repository\Redis\PersistCrosswordRepository;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Constructor\Message\GenerateCrosswordMessageHandler
 */
final class GenerateCrosswordMessageHandlerTest extends CrosswordTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testGenerateCrosswordMessageHandler(): void
    {
        $cache = new InMemoryClient();

        $row = new Row(new Cell(new Coordinate(1, 1), null));
        $crosswordDto = new CrosswordDto(new LineDto(new Line($row), new Word('test', 'test test')));
        $mockConstructor = $this->createMock(ConstructorInterface::class);
        $mockConstructor->method('build')->willReturn($crosswordDto);

        $mockFactory = $this->createMock(ConstructorFactory::class);
        $mockFactory->method('create')->willReturn($mockConstructor);

        $handler = new GenerateCrosswordMessageHandler(new PersistCrosswordRepository($cache), $mockFactory);
        $handler(new GenerateCrosswordMessage('ua', Type::NORMAL, 3));

        self::assertTrue($cache->getItem('ua-normal-3')->isHit());
    }
}
