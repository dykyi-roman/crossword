<?php

declare(strict_types=1);

namespace App\Tests\Game\Domain\Model;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\PlayerId;
use App\Tests\GameTestCase;

/**
 * @coversDefaultClass \App\Game\Domain\Model\Player
 */
final class PlayerTest extends GameTestCase
{
    /**
     * @covers ::changeLevel
     */
    public function testRaiseEventWhenLevelIsChanged(): void
    {
        $player = $this->createPlayer(new PlayerId());
        $player->changeLevel(new Level(Level::LEVEL_4));

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
