<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Request\LoginRequest;
use App\SharedKernel\Application\Response\Web\ResponseInterface;
use App\SharedKernel\Application\Response\Web\TwigResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ViewLoginPageAction
{
    #[Route('/game/login', name: 'web.game.login.view', methods: ['GET'])]
    public function __invoke(LoginRequest $request): ResponseInterface
    {
        return new TwigResponse('@game/login.html.twig');
    }
}
