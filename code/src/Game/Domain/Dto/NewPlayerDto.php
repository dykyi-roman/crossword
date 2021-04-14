<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use Ramsey\Uuid\UuidInterface;

/**
 * @psalm-immutable
 */
final class NewPlayerDto
{
    private string $password;
    private PlayerDto $playerDto;

    public function __construct(string $password, PlayerDto $playerDto)
    {
        $this->password = $password;
        $this->playerDto = $playerDto;
    }

    public function id(): UuidInterface
    {
        return $this->playerDto->id();
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
