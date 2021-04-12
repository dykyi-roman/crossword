<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\PlayerLoginDto;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;

interface ReadPlayerRepositoryInterface
{
    /**
     * @throws PlayerNotFoundException
     */
    public function login(string $nickname, string $password): PlayerLoginDto;
}
