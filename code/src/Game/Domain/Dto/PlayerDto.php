<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\PlayerId;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class PlayerDto implements JsonSerializable
{
    private Role $role;
    private Level $level;
    private PlayerId $playerId;
    private string $nickname;

    public function __construct(PlayerId $playerId, string $nickname, Level $level, Role $role)
    {
        $this->playerId = $playerId;
        $this->role = $role;
        $this->level = $level;
        $this->nickname = $nickname;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
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
            'id' => (string) $this->playerId,
            'nickname' => $this->nickname,
            'level' => (int) $this->level->getValue(),
            'role' => (string) $this->role->getValue(),
        ];
    }
}
