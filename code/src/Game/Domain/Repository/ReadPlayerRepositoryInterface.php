<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\PlayerDto;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface ReadPlayerRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerById(UuidInterface $uuid): PlayerDto;

    /**
     * @throws PlayerNotFoundException
     */
    public function findPlayerByNicknameAndPassword(string $nickname, string $password): PlayerDto;
}
