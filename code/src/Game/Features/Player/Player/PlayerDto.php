<?php

declare(strict_types=1);

namespace App\Game\Features\Player\Player;

use JsonSerializable;

/**
 * @psalm-immutable
 */
final class PlayerDto implements JsonSerializable
{
    private Role $role;
    private PlayerId $playerId;
    private int $level;
    private string $nickname;

    public function __construct(PlayerId $playerId, string $nickname, int $level, Role $role)
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

    public function level(): int
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
            'level' => $this->level,
            'role' => (string) $this->role->getValue(),
        ];
    }
}
