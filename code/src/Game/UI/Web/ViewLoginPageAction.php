<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Request\LoginRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ViewLoginPageAction extends AbstractController
{
    #[Route('/game/login', name: 'web.game.login.view', methods: ['GET'])]
    public function __invoke(LoginRequest $request): Response
    {
        return $this->render('@game/login.html.twig');
    }
}
