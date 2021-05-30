<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Answers;

use App\Game\Features\Answers\Answers;
use App\Game\Features\Answers\AnswersValidator;
use App\Game\Features\Answers\Authentication\PlayerFromTokenExtractor;
use App\Game\Features\Answers\CrosswordPuzzleSolvedEvent;
use App\Game\Features\Answers\Player\PlayerId as AnswersPlayerId;
use App\Game\Features\Player\Player\PlayerId as PlayerPlayerId;
use App\Game\Features\Player\Player\Role;
use App\Game\Infrastructure\Encoder\Base64Encoder;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use App\Tests\Game\GameTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @coversDefaultClass \App\Game\Features\Answers\Answers
 */
final class AnswersTest extends GameTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testIncreaseLevelWneAllAnswersIsCorrect(): void
    {
        $playerId = new PlayerPlayerId();
        $repository = new InMemoryPlayerRepository($this->createPlayer($playerId));
        $answers = new Answers(
            new AnswersValidator(new Base64Encoder()),
            $this->createPlayerFromTokenExtractor($playerId),
            $this->messageBusMockWithConsecutive(
                self::once(),
                new CrosswordPuzzleSolvedEvent(new AnswersPlayerId($playerId->id()), 4)
            )
        );

        $encoder = new Base64Encoder();
        $answers->__invoke([
            ['index' => 0, 'letter' => $encoder->encode('t'), 'value' => 't'],
            ['index' => 1, 'letter' => $encoder->encode('e'), 'value' => 'e'],
            ['index' => 2, 'letter' => $encoder->encode('s'), 'value' => 's'],
            ['index' => 3, 'letter' => $encoder->encode('t'), 'value' => 't'],
        ]);

        $repository->findPlayerById($playerId->id());
    }

    private function createPlayerFromTokenExtractor(PlayerPlayerId $playerId): PlayerFromTokenExtractor
    {
        $player['id'] = (string) $playerId;
        $player['nickname'] = 'test';
        $player['level'] = 3;
        $player['role'] = (new Role(Role::SIMPLE_PLAYER))->getValue();

        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn(json_encode($player, JSON_THROW_ON_ERROR));

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->method('getToken')->willReturn($tokenMock);

        return new PlayerFromTokenExtractor($tokenStorageMock);
    }
}
