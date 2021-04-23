<?php

declare(strict_types=1);

namespace App\Game\Domain\Model;

use App\Game\Domain\Enum\Level;
use DateTimeImmutable;

final class History
{
    private HistoryId $historyId;
    private PlayerId $playerId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private int $level;

    public function __construct(HistoryId $historyId)
    {
        $this->historyId = $historyId;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function changeLevel(Level $level): void
    {
        $this->level = (int) $level->getValue();

        $this->updatedAt = new DateTimeImmutable();
    }

    public function changePlayer(PlayerId $playerId): void
    {
        $this->playerId = $playerId;

        $this->updatedAt = new DateTimeImmutable();
    }

    public function historyId(): HistoryId
    {
        return $this->historyId;
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
