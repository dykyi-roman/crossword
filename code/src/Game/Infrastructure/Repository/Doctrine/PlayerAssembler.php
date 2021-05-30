<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Features\Authorization\PlayerDto;
use App\Game\Features\Player\Player\Player;

final class PlayerAssembler
{
    public function toPlayerDto(Player $player): PlayerDto
    {
        return new PlayerDto(
            $player->playerId()->id(),
            $player->nickname(),
            $player->level(),
            $player->role()->getValue()
        );
    }
}
