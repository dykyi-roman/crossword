<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Features\History\History;
use App\Game\Features\History\HistoryId;
use App\Game\Features\History\PersistHistoryRepositoryInterface;
use App\Game\Features\History\PlayerId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PersistHistoryRepository extends ServiceEntityRepository implements PersistHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function createHistory(HistoryId $historyId, PlayerId $playerId, int $level): void
    {
        $history = new History($historyId);
        $history->changePlayer($playerId);
        $history->changeLevel($level);

        $this->store($history);
    }

    private function store(History $history): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($history);
        $entityManager->flush($history);
    }
}
