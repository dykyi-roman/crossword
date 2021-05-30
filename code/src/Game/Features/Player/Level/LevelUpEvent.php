<?php

declare(strict_types=1);

namespace App\Game\Features\Player\Level;

use App\Game\Features\Player\DomainEventInterface;
use App\Game\Features\Player\Player\PlayerId;

final class LevelUpEvent implements DomainEventInterface
{
    private int $level;
    private string $playerId;

    public function __construct(PlayerId $playerId, int $level)
    {
        $this->playerId = (string) $playerId;
        $this->level = $level;
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
