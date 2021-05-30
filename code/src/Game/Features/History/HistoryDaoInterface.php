<?php

declare(strict_types=1);

namespace App\Game\Features\History;

interface HistoryDaoInterface
{
    public const LIMIT = 10;

    /**
     * @return HistoryRatingDto[]
     */
    public function ratingHistory(int $limit = self::LIMIT): array;
}
