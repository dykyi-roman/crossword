<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Enum\Level;
use Ramsey\Uuid\UuidInterface;

interface PersistHistoryRepositoryInterface
{
    public function createHistory(UuidInterface $uuid, UuidInterface $player, Level $level): void;
}
