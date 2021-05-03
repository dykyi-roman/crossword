<?php

declare(strict_types=1);

namespace App\Game\Domain\Events\Handler;

use App\Game\Domain\Events\Event\LevelUpEvent;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use App\Game\Domain\Service\PlayerTokenHack;
use JsonException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

final class RefreshPlayerInTokenHandler implements MessageHandlerInterface
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
        $playerDto = $this->readPlayerRepository->findPlayerById(new PlayerId(UuidV4::fromString($event->playerId())));
        $this->playerToken->refresh($playerDto);
    }
}
