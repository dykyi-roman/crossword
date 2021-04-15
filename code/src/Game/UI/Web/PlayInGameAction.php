<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\Game\Application\Service\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PlayInGameAction extends AbstractController
{
    #[Route('/game/play', name: 'web.game.play.view', methods: ['GET'])]
    public function __invoke(PlayerFromTokenExtractor $extractor, Game $game): Response | RedirectResponse
    {
        //@todo move to auth layer
        try {
            $player = $extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return $this->redirectToRoute('web.game.login.view');
        }

        $game->new();

        return $this->render('@game/play.html.twig', [
            'grid' => $game->grid(),
            'gridSize' => $game->size(),
        ]);
    }
}
