<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\PlayerLoginException;
use App\Game\Application\Request\LoginRequest;
use App\Game\Application\Service\Auth\PlayerLogin;
use Symfony\Component\Routing\Annotation\Route;

final class PlayerAuthAction
{
    #[Route('/game/login/post', name: 'web.game.login.post', methods: ['POST'])]
    public function __invoke(LoginRequest $request, PlayerLogin $playerLogin): string
    {
        try {
            $playerLogin($request->nickname(), $request->password());

            return 'Player successfully logged!';
        } catch (PlayerLoginException) {
            return 'Failed!';
        }
    }
}
