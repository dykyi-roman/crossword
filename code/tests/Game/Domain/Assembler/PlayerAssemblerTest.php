<?php

declare(strict_types=1);

namespace App\Tests\Game\Domain\Assembler;

use App\Game\Domain\Assembler\PlayerAssembler;
use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Model\PlayerId;
use App\Tests\GameTestCase;

/**
 * @coversDefaultClass \App\Game\Domain\Assembler\PlayerAssembler
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
