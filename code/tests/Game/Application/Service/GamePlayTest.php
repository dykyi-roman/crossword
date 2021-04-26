<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Service;

use App\Game\Application\Dto\GameDto;
use App\Game\Application\Enum\Type;
use App\Game\Application\Enum\WordCount;
use App\Game\Application\Service\GamePlay;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Port\CrosswordInterface;
use App\Game\Domain\Service\CrosswordConstructor;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Game\Application\Service\GamePlay
 */
final class GamePlayTest extends TestCase
{
    /**
     * @covers ::new
     */
    public function testCreateNewGame(): void
    {
        $response = new SuccessApiResponse([
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
        );
        $crossword = new CrosswordDto($response->body());

        $crosswordMock = $this->createMock(CrosswordInterface::class);
        $crosswordMock->method('construct')->willReturn($crossword);

        $gamePlay = new GamePlay(new CrosswordConstructor($crosswordMock, new NullLogger()));
        $gameDto = $gamePlay->new(
            'en',
            Type::byRole(new Role(Role::SIMPLE_PLAYER)),
            WordCount::byLevel(new Level(Level::LEVEL_3))
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
