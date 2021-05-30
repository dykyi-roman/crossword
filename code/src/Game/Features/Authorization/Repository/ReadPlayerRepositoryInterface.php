<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization\Repository;

use App\Game\Features\Authorization\PlayerDto;
use Symfony\Component\Uid\UuidV4;

interface ReadPlayerRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerByNicknameAndPassword(string $nickname, string $password): PlayerDto;

    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerById(UuidV4 $playerId): PlayerDto;
}
