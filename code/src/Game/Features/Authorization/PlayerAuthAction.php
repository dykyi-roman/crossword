<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization;

use App\Game\Features\Authorization\Request\LoginRequest;

final class PlayerAuthAction
{
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
