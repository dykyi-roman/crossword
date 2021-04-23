<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Service\PlayerHistory;
use App\SharedKernel\Application\Response\API\ResponseInterface;
use App\SharedKernel\Application\Response\API\SuccessResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PlayerRatingAction
{
    #[Route('/game/player-rating', name: 'web.game.player-rating', methods: ['GET'])]
    public function __invoke(PlayerHistory $playerHistory): ResponseInterface
    {
        return new SuccessResponse($playerHistory());
    }
}