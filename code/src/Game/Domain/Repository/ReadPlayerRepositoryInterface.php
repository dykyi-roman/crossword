<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Exception\PlayerNotFoundException;
use App\Game\Domain\Model\PlayerId;

interface ReadPlayerRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerById(PlayerId $playerId): PlayerDto;

    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerByNicknameAndPassword(string $nickname, string $password): PlayerDto;
}
