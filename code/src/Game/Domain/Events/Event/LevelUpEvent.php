<?php

declare(strict_types=1);

namespace App\Game\Domain\Events\Event;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Events\DomainEventInterface;
use App\Game\Domain\Model\PlayerId;

final class LevelUpEvent implements DomainEventInterface
{
    private int $level;
    private string $playerId;

    public function __construct(PlayerId $playerId, Level $level)
    {
        $this->playerId = (string) $playerId;
        $this->level = (int) $level->getValue();
    }

    public function level(): int
    {
        return $this->level;
    }

    public function playerId(): string
    {
        return $this->playerId;
    }
}
