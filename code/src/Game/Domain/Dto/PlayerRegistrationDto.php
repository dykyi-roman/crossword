<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;

final class PlayerRegistrationDto
{
    private Role $role;
    private Level $level;
    private string $password;
    private string $nickname;

    public function __construct(string $nickname, string $password, Level $level, Role $role)
    {
        $this->password = $password;
        $this->nickname = $nickname;
        $this->level = $level;
        $this->role = $role;
    }

    public function level(): Level
    {
        return $this->level;
    }

    public function role(): Role
    {
        return $this->role;
    }

    public function nickname(): string
    {
        return $this->nickname;
    }

    public function password(): string
    {
        return $this->password;
    }
}
