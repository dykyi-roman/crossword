<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\PlayerId;
use PHPUnit\Framework\TestCase;

abstract class GameTestCase extends TestCase
{
    public function createPlayer(PlayerId $playerId): Player
    {
        $player = new Player($playerId);
        $player->changeNickname('test');
        $player->changePassword('1q2w3e4r');
        $player->changeLevel(new Level(Level::LEVEL_3));
        $player->changeRole(new Role(Role::SIMPLE_PLAYER));

        return $player;
    }
}
