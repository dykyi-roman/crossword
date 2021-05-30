<?php

declare(strict_types=1);

namespace App\Game\Features\Registration;

use App\Game\Features\Registration\Player\PlayerDto;

interface PlayerRepositoryInterface
{
    public function createPlayer(PlayerDto $playerDto): void;
}
