<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\History;
use App\Game\Domain\Model\HistoryId;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\PersistHistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PersistHistoryRepository extends ServiceEntityRepository implements PersistHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function createHistory(HistoryId $historyId, PlayerId $playerId, Level $level): void
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
        $entityManager->flush();
    }
}
