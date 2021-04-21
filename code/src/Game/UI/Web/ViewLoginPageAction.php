<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Request\LoginRequest;
use App\SharedKernel\Application\Response\Web\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ViewLoginPageAction
{
    #[Route('/game/login', name: 'web.game.login.view', methods: ['GET'])]
    public function __invoke(LoginRequest $request): Response
    {
        return new Response('@game/login.html.twig');
    }
}
