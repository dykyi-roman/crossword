<?php

declare(strict_types=1);

namespace App\Game\Features\Answers\Player;

final class PlayerDto
{
    private int $level;
    private PlayerId $playerId;

    public function __construct(PlayerId $playerId, int $level)
    {
        $this->playerId = $playerId;
        $this->level = $level;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function id(): PlayerId
    {
        return $this->playerId;
    }
}
