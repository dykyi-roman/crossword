<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Dto\LineDto;
use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Messages\Handler\GenerateCrosswordMessageHandler;
use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Model\Cell;
use App\Crossword\Domain\Model\Coordinate;
use App\Crossword\Domain\Model\Line;
use App\Crossword\Domain\Model\Row;
use App\Crossword\Domain\Service\Constructor\ConstructorFactory;
use App\Crossword\Domain\Service\Constructor\ConstructorInterface;
use App\Crossword\Infrastructure\Cache\InMemoryClient;
use App\SharedKernel\Domain\Model\Word;
use App\Tests\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Domain\Messages\Handler\GenerateCrosswordMessageHandler
 */
final class GenerateCrosswordMessageHandlerTest extends CrosswordTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testA(): void
    {
        $cache = new InMemoryClient();

        $row = new Row(new Cell(new Coordinate(1,1), null));
        $crosswordDto = new CrosswordDto(new LineDto(new Line($row), new Word('test', 'test test')));
        $mockConstructor = $this->createMock(ConstructorInterface::class);
        $mockConstructor->method('build')->willReturn($crosswordDto);

        $mockFactory = $this->createMock(ConstructorFactory::class);
        $mockFactory->method('create')->willReturn($mockConstructor);

        $handler = new GenerateCrosswordMessageHandler($cache, $mockFactory);
        $handler(new GenerateCrosswordMessage('ua', Type::NORMAL, 3));

        self::assertTrue($cache->getItem('ua-normal-3')->isHit());
    }
}
