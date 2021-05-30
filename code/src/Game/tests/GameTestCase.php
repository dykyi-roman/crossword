<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Features\Player\Player\Player;
use App\Game\Features\Player\Player\PlayerId;
use App\Game\Features\Player\Player\Role;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class GameTestCase extends TestCase
{
    public function createPlayer(PlayerId $playerId): Player
    {
        $player = new Player($playerId);
        $player->changeNickname('test');
        $player->changePassword('1q2w3e4r');
        $player->changeLevel(3);
        $player->changeRole(new Role(Role::SIMPLE_PLAYER));

        return $player;
    }

    protected function messageBusMockWithConsecutive(
        InvocationOrder $invocationRule,
        $message = null
    ): MessageBusInterface {
        if (null === $message) {
            $messageBus = $this->createMock(MessageBusInterface::class);
            $messageBus->expects($invocationRule)->method('dispatch');

            return $messageBus;
        }

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($invocationRule)
            ->method('dispatch')
            ->withConsecutive(
                [
                    self::isInstanceOf(get_class($message)),
                ]
            )
            ->willReturn(new Envelope($message));

        return $messageBus;
    }
}
