<?php

declare(strict_types=1);

namespace App\Game\Features\Player\Player;

use App\Game\Features\Player\AggregateRoot;
use App\Game\Features\Player\Level\Level;
use App\Game\Features\Player\Level\LevelUpEvent;
use DateTimeImmutable;

class Player extends AggregateRoot
{
    private PlayerId $playerId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private string $password;
    private string $nickname;
    private string $role;
    private int $level;

    public function __construct(PlayerId $playerId)
    {
        $this->playerId = $playerId;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function changeRole(Role $role): void
    {
        $this->role = (string) $role->getValue();
    }

    public function changeNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }

    public function changeLevel(int $level): void
    {
        $this->level = $level;

        $this->updatedAt = new DateTimeImmutable();

        if (Level::LAST_LEVEL > $this->level) {
            $this->raise(new LevelUpEvent($this->playerId, $level));
        }
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
        return new Role($this->role);
    }

    public function password(): string
    {
        return $this->password;
    }

    public function nickname(): string
    {
        return $this->nickname;
    }
}
