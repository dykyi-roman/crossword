<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\Game\Application\Service\PlayGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PlayInGameAction extends AbstractController
{
    #[Route('/game/play', name: 'web.game.play.view', methods: ['GET'])]
    public function __invoke(PlayerFromTokenExtractor $extractor, PlayGame $playGame): Response | RedirectResponse
    {
        try {
            $player = $extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return $this->redirectToRoute('web.game.login.view');
        }

        dump($player, $playGame->play());

        return $this->render('@game/play.html.twig');
    }
}
