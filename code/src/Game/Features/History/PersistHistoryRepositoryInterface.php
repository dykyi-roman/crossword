<?php

declare(strict_types=1);

namespace App\Game\Features\History;

interface PersistHistoryRepositoryInterface
{
    public function createHistory(HistoryId $historyId, PlayerId $playerId, int $level): void;
}
