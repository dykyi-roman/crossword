<?php

declare(strict_types=1);

namespace App\Game\Features\History;

use App\Game\Features\Player\Level\LevelUpEvent;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

final class SaveHistoryEventHandler implements MessageHandlerInterface
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
            $event->level()
        );
    }
}
