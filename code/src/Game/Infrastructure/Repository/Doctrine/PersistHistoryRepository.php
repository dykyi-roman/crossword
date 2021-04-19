<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\History;
use App\Game\Domain\Repository\PersistHistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

final class PersistHistoryRepository extends ServiceEntityRepository implements PersistHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function createHistory(UuidInterface $uuid, UuidInterface $player, Level $level): void
    {
        $history = new History($uuid);
        $history->changePlayer($player);
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
