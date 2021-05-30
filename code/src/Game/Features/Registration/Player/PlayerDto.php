<?php

declare(strict_types=1);

namespace App\Game\Features\Registration\Player;

use App\Game\Features\Registration\Role\Role;
use JsonSerializable;

/**
 * @psalm-immutable
 */
final class PlayerDto implements JsonSerializable
{
    private Role $role;
    private PlayerId $playerId;
    private string $password;
    private string $nickname;

    public function __construct(PlayerId $playerId, string $password, string $nickname, Role $role)
    {
        $this->playerId = $playerId;
        $this->role = $role;
        $this->nickname = $nickname;
        $this->password = $password;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
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

    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->playerId,
            'nickname' => $this->nickname,
            'password' => $this->password,
            'level' => 1,
            'role' => (string) $this->role->getValue(),
        ];
    }
}
