<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Dao\Doctrine;

use App\Game\Features\History\HistoryDaoInterface;
use App\Game\Features\History\HistoryRatingDto;
use Doctrine\DBAL\Connection;

final class HistoryDao implements HistoryDaoInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function ratingHistory(int $limit = self::LIMIT): array
    {
        $records = $this->connection->createQueryBuilder()
            ->addSelect('p.nickname')
            ->addSelect('h.level')
            ->addSelect('(strftime("%s", max(h.createdAt)) - strftime("%s", min(H.createdAt))) as date')
            ->from('history', 'h')
            ->innerJoin('h', 'player', 'p', 'h.player = p.id')
            ->addOrderBy('date', 'ASC')
            ->addOrderBy('h.level', 'DESC')
            ->addGroupBy('p.nickname')
            ->setMaxResults($limit)
            ->execute()
            ->fetchAllAssociative();

        return array_map(
            static fn (array $record): HistoryRatingDto => new HistoryRatingDto(
                $record['nickname'],
                (int) $record['level']
            ),
            $records
        );
    }
}
