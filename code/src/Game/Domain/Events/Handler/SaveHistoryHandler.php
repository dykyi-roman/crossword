<?php

declare(strict_types=1);

namespace App\Game\Domain\Events\Handler;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Events\Event\LevelUpEvent;
use App\Game\Domain\Model\HistoryId;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\PersistHistoryRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

final class SaveHistoryHandler implements MessageHandlerInterface
{
    private PersistHistoryRepositoryInterface $persistHistoryRepository;

    public function __construct(PersistHistoryRepositoryInterface $persistHistoryRepository)
    {
        $this->persistHistoryRepository = $persistHistoryRepository;
    }

    public function __invoke(LevelUpEvent $event): void
    {
        $this->persistHistoryRepository->createHistory(
            new HistoryId(),
            new PlayerId(UuidV4::fromString($event->playerId())),
            new Level($event->level())
        );
    }
}
