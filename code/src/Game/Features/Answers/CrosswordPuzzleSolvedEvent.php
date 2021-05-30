<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

use App\Game\Features\Answers\Player\PlayerId;
use Symfony\Component\Uid\UuidV4;

final class CrosswordPuzzleSolvedEvent
{
    private int $level;
    private UuidV4 $playerId;

    public function __construct(PlayerId $playerId, int $level)
    {
        $this->level = $level;
        $this->playerId = $playerId->id();
    }

    public function playerId(): UuidV4
    {
        return $this->playerId;
    }

    public function level(): int
    {
        return $this->level;
    }
}
