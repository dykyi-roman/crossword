<?php

declare(strict_types=1);

namespace App\Game\Domain\Model;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

final class Player
{
    private UuidInterface $id;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private string $password;
    private string $nickname;
    private string $role;
    private int $level;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
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

    public function changeLevel(Level $level): void
    {
        $this->level = (int) $level->getValue();

        $this->updatedAt = new DateTimeImmutable();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function level(): Level
    {
        return new Level($this->level);
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
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
