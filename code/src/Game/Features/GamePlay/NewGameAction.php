<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay;

use App\Game\Features\GamePlay\Authentication\PlayerFromTokenExtractor;
use App\Game\Features\GamePlay\Authentication\PlayerNotFoundInTokenStorageException;
use App\Game\Features\GamePlay\Crossword\Type;
use Twig\Environment;

final class NewGameAction
{
    private PlayerFromTokenExtractor $extractor;

    public function __construct(PlayerFromTokenExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    public function __invoke(GamePlay $game, Environment $twig): string
    {
        try {
            $playerDto = $this->extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return 'Login session is over.';
        }

        $gameDto = $game->new('en', Type::byRole($playerDto->role()), $playerDto->level() * 3);

        return $twig->render('@game/play.html.twig', [
            'player' => $playerDto,
            'game' => $gameDto,
        ]);
    }
}
