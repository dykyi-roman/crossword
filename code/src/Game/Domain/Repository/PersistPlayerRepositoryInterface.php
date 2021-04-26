<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\RegisteredPlayerDto;
use App\Game\Domain\Exception\PlayerNotFoundException;
use App\Game\Domain\Model\PlayerId;

interface PersistPlayerRepositoryInterface
{
    public function createPlayer(RegisteredPlayerDto $playerDto): void;

    /**
     * @throws PlayerNotFoundException
     */
    public function levelUp(PlayerId $playerId): void;
}
