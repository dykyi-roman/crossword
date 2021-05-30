<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization;

use App\Game\Features\Authorization\Request\LoginRequest;
use Twig\Environment;

final class ViewLoginPageAction
{
    public function __invoke(LoginRequest $request, Environment $twig): string
    {
        return $twig->render('@game/login.html.twig');
    }
}
