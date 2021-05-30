<?php

declare(strict_types=1);

namespace App\Tests\Game\Infrastructure\Repository\Doctrine;

use App\Game\Features\Authorization\PlayerDto;
use App\Game\Features\Player\Player\PlayerId;
use App\Game\Infrastructure\Repository\Doctrine\PlayerAssembler;
use App\Tests\Game\GameTestCase;

/**
 * @coversDefaultClass \App\Game\Infrastructure\Repository\Doctrine\PlayerAssembler
 */
final class PlayerAssemblerTest extends GameTestCase
{
    /**
     * @covers ::toPlayerDto
     */
    public function testPlayerAssembler(): void
    {
        $playerAssembler = new PlayerAssembler();
        $playerDto = $playerAssembler->toPlayerDto($this->createPlayer(new PlayerId()));

        self::assertInstanceOf(PlayerDto::class, $playerDto);
    }
}
