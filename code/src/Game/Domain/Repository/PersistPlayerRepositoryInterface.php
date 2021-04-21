<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\NewPlayerDto;
use App\Game\Domain\Model\PlayerId;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;

interface PersistPlayerRepositoryInterface
{
    public function createPlayer(NewPlayerDto $playerDto): void;

    /**
     * @throws PlayerNotFoundException
     */
    public function levelUp(PlayerId $playerId): void;
}
