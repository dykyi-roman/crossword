<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Dao\InMemory;

use App\Game\Features\History\History;
use App\Game\Features\History\HistoryDaoInterface;
use App\Game\Features\History\HistoryRatingDto;

final class InMemoryHistoryDao implements HistoryDaoInterface
{
    /**
     * @var History[]
     */
    private array $histories;

    public function __construct(History ...$history)
    {
        $this->histories = array_reduce(
            $history,
            static function (array $histories, History $history): array {
                $histories[(string) $history->historyId()] = $history;

                return $histories;
            },
            []
        );
    }

    public function ratingHistory(int $limit = self::LIMIT): array
    {
        return array_map(
            static fn (History $history) => new HistoryRatingDto('test', $history->level()),
            $this->histories
        );
    }

    /**
     * @return History[]
     */
    public function histories(): array
    {
        return $this->histories;
    }
}
