<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\HistoryId;
use App\Game\Domain\Model\PlayerId;

interface PersistHistoryRepositoryInterface
{
    public function createHistory(HistoryId $historyId, PlayerId $playerId, Level $level): void;
}
