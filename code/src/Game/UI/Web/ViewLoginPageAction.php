<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Request\LoginRequest;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class ViewLoginPageAction
{
    #[Route('/game/login', name: 'web.game.login.view', methods: ['GET'])]
    public function __invoke(LoginRequest $request, Environment $twig): string
    {
        return $twig->render('@game/login.html.twig');
    }
}
