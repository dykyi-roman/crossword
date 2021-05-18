<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Enum\Type;
use App\Game\Application\Enum\WordCount;
use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Application\Service\GamePlay;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class NewGameAction
{
    private PlayerFromTokenExtractor $extractor;

    public function __construct(PlayerFromTokenExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    #[Route('/game/play', name: 'web.game.play.view', methods: ['GET'])]
    public function __invoke(GamePlay $game, Environment $twig): string
    {
        try {
            $playerDto = $this->extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return 'Login session is over.';
        }

        $gameDto = $game->new('en', Type::byRole($playerDto->role()), WordCount::byLevel($playerDto->level()));

        return $twig->render('@game/play.html.twig', [
            'player' => $playerDto,
            'game' => $gameDto,
        ]);
    }
}
