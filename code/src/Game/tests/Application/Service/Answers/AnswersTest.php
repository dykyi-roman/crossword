<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Service\Answers;

use App\Game\Application\Service\Answers\Answers;
use App\Game\Application\Service\Answers\AnswersValidator;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\PlayerId;
use App\Game\Infrastructure\Encoder\Base64Encoder;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use App\Tests\Game\GameTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @coversDefaultClass \App\Game\Application\Service\Answers\Answers
 */
final class AnswersTest extends GameTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testIncreaseLevelWneAllAnswersIsCorrect(): void
    {
        $playerId = new PlayerId();
        $repository = new InMemoryPlayerRepository($this->createPlayer($playerId));
        $answers = new Answers(
            new AnswersValidator(new Base64Encoder()),
            $this->createPlayerFromTokenExtractor($playerId),
            $repository,
        );

        $encoder = new Base64Encoder();
        $answers->__invoke([
            ['index' => 0, 'letter' => $encoder->encode('t'), 'value' => 't'],
            ['index' => 1, 'letter' => $encoder->encode('e'), 'value' => 'e'],
            ['index' => 2, 'letter' => $encoder->encode('s'), 'value' => 's'],
            ['index' => 3, 'letter' => $encoder->encode('t'), 'value' => 't'],
        ]);

        $player = $repository->findPlayerById($playerId);
        self::assertTrue($player->level()->equals(new Level(Level::LEVEL_4)));
    }

    private function createPlayerFromTokenExtractor(PlayerId $playerId): PlayerFromTokenExtractor
    {
        $player['id'] = (string) $playerId;
        $player['nickname'] = 'test';
        $player['level'] = (new Level(Level::LEVEL_3))->getValue();
        $player['role'] = (new Role(Role::SIMPLE_PLAYER))->getValue();

        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn(json_encode($player, JSON_THROW_ON_ERROR));

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->method('getToken')->willReturn($tokenMock);

        return new PlayerFromTokenExtractor($tokenStorageMock);
    }
}
