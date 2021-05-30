<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Answers\Authentication;

use App\Game\Features\Answers\Authentication\PlayerFromTokenExtractor;
use App\Game\Features\Answers\Authentication\PlayerNotFoundInTokenStorageException;
use App\Game\Features\Answers\Player\PlayerDto;
use App\Game\Features\Player\Player\PlayerId;
use App\Tests\Game\GameTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @coversDefaultClass \App\Game\Features\Answers\Authentication\PlayerFromTokenExtractor
 */
final class PlayerFromTokenExtractorTest extends GameTestCase
{
    /**
     * @covers ::player
     */
    public function testExtractPlayerFromTokenStorage(): void
    {
        $player = $this->createPlayer(new PlayerId());

        $playerArray['id'] = (string) $player->playerId();
        $playerArray['nickname'] = $player->nickname();
        $playerArray['level'] = $player->level();
        $playerArray['role'] = $player->role()->getValue();

        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn(json_encode($playerArray, JSON_THROW_ON_ERROR));

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->method('getToken')->willReturn($tokenMock);

        $playerFromTokenExtractor = new PlayerFromTokenExtractor($tokenStorageMock);

        self::assertInstanceOf(PlayerDto::class, $playerFromTokenExtractor->player());
    }

    /**
     * @covers ::player
     */
    public function testRaiseExceptionWhenTokenIsNull(): void
    {
        $this->expectException(PlayerNotFoundInTokenStorageException::class);

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->method('getToken')->willReturn(null);

        $playerFromTokenExtractor = new PlayerFromTokenExtractor($tokenStorageMock);
        $playerFromTokenExtractor->player();
    }

    /**
     * @covers ::player
     */
    public function testRaiseExceptionWhenPlayerIsNotDecoded(): void
    {
        $this->expectException(PlayerNotFoundInTokenStorageException::class);

        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn('', JSON_THROW_ON_ERROR);

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->method('getToken')->willReturn($tokenMock);

        $playerFromTokenExtractor = new PlayerFromTokenExtractor($tokenStorageMock);
        $playerFromTokenExtractor->player();
    }
}
