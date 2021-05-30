<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization;

use JsonSerializable;
use Symfony\Component\Uid\UuidV4;

/**
 * @psalm-immutable
 */
final class PlayerDto implements JsonSerializable
{
    private int $level;
    private string $role;
    private string $nickname;
    private UuidV4 $playerId;

    public function __construct(UuidV4 $playerId, string $nickname, int $level, string $role)
    {
        $this->playerId = $playerId;
        $this->role = $role;
        $this->level = $level;
        $this->nickname = $nickname;
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->playerId->toRfc4122(),
            'nickname' => $this->nickname,
            'level' => $this->level,
            'role' => $this->role,
        ];
    }
}
