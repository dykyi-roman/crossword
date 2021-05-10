<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Service\Auth;

use App\Game\Application\Exception\PlayerLoginException;
use App\Game\Application\Service\Auth\PlayerLogin;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Service\PlayerTokenHack;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use App\Tests\GameTestCase;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @coversDefaultClass \App\Game\Application\Service\Auth\PlayerLogin
 */
final class PlayerLoginTest extends GameTestCase
{
    /**
     * @covers ::__invoke
     */
    public function testSuccessfullyPlayerLogin(): void
    {
        $sessionMock = $this->createMock(SessionInterface::class);
        $sessionMock->expects(self::once())->method('set');

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->expects(self::once())->method('setToken');

        $player = $this->createPlayer(new PlayerId());
        $playerLogin = new PlayerLogin(
            new NullLogger(),
            new PlayerTokenHack($tokenStorageMock, $sessionMock),
            new InMemoryPlayerRepository($player)
        );

        $playerLogin->__invoke($player->nickname(), $player->password());
    }

    /**
     * @covers ::__invoke
     */
    public function testPlayerNotFoundInTheStorage(): void
    {
        $this->expectException(PlayerLoginException::class);

        $sessionMock = $this->createMock(SessionInterface::class);
        $sessionMock->expects(self::never())->method('set');

        $tokenStorageMock = $this->createMock(TokenStorageInterface::class);
        $tokenStorageMock->expects(self::never())->method('setToken');

        $playerLogin = new PlayerLogin(
            new NullLogger(),
            new PlayerTokenHack($tokenStorageMock, $sessionMock),
            new InMemoryPlayerRepository()
        );

        $playerLogin->__invoke("test", '1q2w3e4r');
    }
}
