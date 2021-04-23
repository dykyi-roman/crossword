<?php

declare(strict_types=1);

namespace App\Game\Domain\Events\Event;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\PlayerId;
use App\SharedKernel\Domain\Events\DomainEventInterface;

final class LevelUpEvent implements DomainEventInterface
{
    private int $level;
    private string $playerId;

    public function __construct(PlayerId $playerId, Level $level)
    {
        $id = $playerId->id();
        $this->playerId = $id->toString();
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
