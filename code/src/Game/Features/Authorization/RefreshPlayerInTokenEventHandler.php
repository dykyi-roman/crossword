<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization;

use App\Game\Features\Authorization\Repository\ReadPlayerRepositoryInterface;
use App\Game\Features\Player\Level\LevelUpEvent;
use JsonException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

final class RefreshPlayerInTokenEventHandler implements MessageHandlerInterface
{
    private PlayerTokenHack $playerToken;
    private ReadPlayerRepositoryInterface $readPlayerRepository;

    public function __construct(PlayerTokenHack $playerToken, ReadPlayerRepositoryInterface $readPlayerRepository)
    {
        $this->playerToken = $playerToken;
        $this->readPlayerRepository = $readPlayerRepository;
    }

    /**
     * @throws JsonException
     */
    public function __invoke(LevelUpEvent $event): void
    {
        $playerDto = $this->readPlayerRepository->findPlayerById(UuidV4::fromString($event->playerId()));
        $this->playerToken->refresh($playerDto);
    }
}
