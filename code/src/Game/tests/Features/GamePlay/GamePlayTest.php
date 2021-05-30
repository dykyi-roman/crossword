<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\GamePlay;

use App\Game\Features\GamePlay\Crossword\CrosswordConstructor;
use App\Game\Features\GamePlay\Crossword\CrosswordDto;
use App\Game\Features\GamePlay\Crossword\CrosswordInterface;
use App\Game\Features\GamePlay\Crossword\GameDto;
use App\Game\Features\GamePlay\Crossword\Type;
use App\Game\Features\GamePlay\GamePlay;
use App\Game\Features\GamePlay\Player\Role;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Game\Features\GamePlay\GamePlay
 */
final class GamePlayTest extends TestCase
{
    /**
     * @covers ::new
     */
    public function testCreateNewGame(): void
    {
        $crossword = new CrosswordDto([
            'success' => true,
            'data' => [
                [
                    'line' => [
                        ['coordinate' => '1.1', 'letter' => 't'],
                        ['coordinate' => '1.2', 'letter' => 'e'],
                        ['coordinate' => '1.3', 'letter' => 's'],
                        ['coordinate' => '1.4', 'letter' => 't'],
                    ],
                    'word' => ['definition' => 'test']
                ]
            ]
        ]);

        $crosswordMock = $this->createMock(CrosswordInterface::class);
        $crosswordMock->method('construct')->willReturn($crossword);

        $gamePlay = new GamePlay(new CrosswordConstructor($crosswordMock, new NullLogger()));
        $gameDto = $gamePlay->new(
            'en',
            Type::byRole(new Role(Role::SIMPLE_PLAYER)),
            3 * 2
        );

        self::assertInstanceOf(GameDto::class, $gameDto);
        self::assertSame(4, $gameDto->size());
        self::assertSame(['test'], $gameDto->definitions());
        self::assertSame('t', $gameDto->grid()['1.1']['letter']);
        self::assertSame('e', $gameDto->grid()['1.2']['letter']);
        self::assertSame('s', $gameDto->grid()['1.3']['letter']);
        self::assertSame('t', $gameDto->grid()['1.4']['letter']);
    }
}
