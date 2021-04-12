<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use JsonSerializable;

class PlayerLoginDto implements JsonSerializable
{
    protected string $nickname;
    protected Level $level;
    protected Role $role;

    public function __construct(string $nickname, Level $level, Role $role)
    {
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

    public function jsonSerialize(): array
    {
        return [
            'nickname' => $this->nickname,
            'level' => (int) $this->level->getValue(),
            'role' => (string) $this->role->getValue(),
        ];
    }
}
