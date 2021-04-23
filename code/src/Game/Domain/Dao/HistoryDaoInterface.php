<?php

declare(strict_types=1);

namespace App\Game\Domain\Dao;

use App\Game\Domain\Dto\HistoryRatingDto;

interface HistoryDaoInterface
{
    public const LIMIT = 10;

    /**
     * @return HistoryRatingDto[]
     */
    public function ratingHistory(int $limit = self::LIMIT): array;
}
