<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Model\History;
use App\Game\Domain\Repository\ReadHistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ReadHistoryRepository extends ServiceEntityRepository implements ReadHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }
}
