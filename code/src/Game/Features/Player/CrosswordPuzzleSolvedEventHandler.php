<?php

declare(strict_types=1);

namespace App\Game\Features\Player;

use App\Game\Features\Answers\CrosswordPuzzleSolvedEvent;
use App\Game\Features\Player\Level\Level;
use App\Game\Features\Player\Level\PlayerLevelRepositoryInterface;
use App\Game\Features\Player\Player\PlayerId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CrosswordPuzzleSolvedEventHandler implements MessageHandlerInterface
{
    private PlayerLevelRepositoryInterface $playerLevelRepository;

    public function __construct(PlayerLevelRepositoryInterface $playerLevelRepository)
    {
        $this->playerLevelRepository = $playerLevelRepository;
    }

    public function __invoke(CrosswordPuzzleSolvedEvent $event)
    {
        if ($event->level() < Level::LAST_LEVEL) {
            $this->playerLevelRepository->changeLevel(new PlayerId($event->playerId()));
        }
    }
}
