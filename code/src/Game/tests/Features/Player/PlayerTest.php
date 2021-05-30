<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Player;

use App\Game\Features\Player\Player\PlayerId;
use App\Tests\Game\GameTestCase;

/**
 * @coversDefaultClass \App\Game\Features\Player\Player\Player
 */
final class PlayerTest extends GameTestCase
{
    /**
     * @covers ::changeLevel
     */
    public function testRaiseEventWhenLevelIsChanged(): void
    {
        $player = $this->createPlayer(new PlayerId());
        $player->changeLevel(4);

        self::assertCount(2, $player->popEvents());
    }

    /**
     * @covers ::changeLevel
     */
    public function testRaiseEventWhenPlayerCreated(): void
    {
        $player = $this->createPlayer(new PlayerId());

        self::assertCount(1, $player->popEvents());
    }
}
