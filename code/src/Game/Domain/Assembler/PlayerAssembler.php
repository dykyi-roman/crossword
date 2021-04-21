<?php

declare(strict_types=1);

namespace App\Game\Domain\Assembler;

use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Model\Player;

final class PlayerAssembler
{
    public function toPlayerDto(Player $player): PlayerDto
    {
        return new PlayerDto($player->id(), $player->nickname(), $player->level(), $player->role());
    }
}
