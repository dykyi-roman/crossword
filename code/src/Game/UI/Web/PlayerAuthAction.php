<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\PlayerLoginException;
use App\Game\Application\Request\LoginRequest;
use App\Game\Application\Service\Auth\PlayerLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PlayerAuthAction extends AbstractController
{
    #[Route('/game/login/post', name: 'web.game.login.post', methods: ['POST'])]
    public function __invoke(LoginRequest $request, PlayerLogin $playerLogin): Response | RedirectResponse
    {
        try {
            $playerLogin($request->nickname(), $request->password());

            return $this->redirectToRoute('web.game.play.view');
        } catch (PlayerLoginException) {
            return new Response('Failed!');
        }
    }
}
