<?php

declare(strict_types=1);

namespace App\Game\Features\Player\Level;

use App\Game\Features\Player\Player\PlayerId;
use App\Game\Features\Player\Player\PlayerNotFoundException;

interface PlayerLevelRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function changeLevel(PlayerId $playerId): void;
}
