<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\PlayerId;

/**
 * @psalm-immutable
 */
final class RegisteredPlayerDto
{
    private string $password;
    private PlayerDto $playerDto;

    public function __construct(string $password, PlayerDto $playerDto)
    {
        $this->password = $password;
        $this->playerDto = $playerDto;
    }

    public function playerId(): PlayerId
    {
        return $this->playerDto->playerId();
    }

    public function level(): Level
    {
        return $this->playerDto->level();
    }

    public function role(): Role
    {
        return $this->playerDto->role();
    }

    public function nickname(): string
    {
        return $this->playerDto->nickname();
    }

    public function password(): string
    {
        return $this->password;
    }
}
