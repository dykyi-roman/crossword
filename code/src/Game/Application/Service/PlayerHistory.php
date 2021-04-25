<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Domain\Dao\HistoryDaoInterface;
use App\Game\Domain\Dto\HistoryRatingDto;

final class PlayerHistory
{
    private HistoryDaoInterface $historyDao;

    public function __construct(HistoryDaoInterface $historyDao)
    {
        $this->historyDao = $historyDao;
    }

    public function __invoke(): array
    {
        return array_map(
            static fn (HistoryRatingDto $dto) => $dto->jsonSerialize(),
            $this->historyDao->ratingHistory()
        );
    }
}
