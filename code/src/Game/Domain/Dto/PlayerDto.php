<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use JsonSerializable;
use Ramsey\Uuid\UuidInterface;

/**
 * @psalm-immutable
 */
final class PlayerDto implements JsonSerializable
{
    private Role $role;
    private Level $level;
    private UuidInterface $id;
    private string $nickname;

    public function __construct(UuidInterface $id, string $nickname, Level $level, Role $role)
    {
        $this->id = $id;
        $this->role = $role;
        $this->level = $level;
        $this->nickname = $nickname;
    }

    public function id(): UuidInterface
    {
        return $this->id;
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
            'id' => $this->id->toString(),
            'nickname' => $this->nickname,
            'level' => (int) $this->level->getValue(),
            'role' => (string) $this->role->getValue(),
        ];
    }
}
