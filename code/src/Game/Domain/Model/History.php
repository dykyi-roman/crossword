<?php

declare(strict_types=1);

namespace App\Game\Domain\Model;

use App\Game\Domain\Enum\Level;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

final class History
{
    private UuidInterface $id;
    private UuidInterface $player;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private int $level;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function changeLevel(Level $level): void
    {
        $this->level = (int) $level->getValue();

        $this->updatedAt = new DateTimeImmutable();
    }

    public function changePlayer(UuidInterface $uuid): void
    {
        $this->player = $uuid;

        $this->updatedAt = new DateTimeImmutable();
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function player(): UuidInterface
    {
        return $this->player;
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
}
