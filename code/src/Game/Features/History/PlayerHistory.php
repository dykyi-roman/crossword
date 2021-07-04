<?php

declare(strict_types=1);

namespace App\Game\Features\History;

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
            static fn (HistoryRatingDto $dto): array => $dto->jsonSerialize(),
            $this->historyDao->ratingHistory()
        );
    }
}
