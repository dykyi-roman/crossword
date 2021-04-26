<?php

declare(strict_types=1);

namespace App\Game\UI\Web;

use App\Game\Application\Enum\Type;
use App\Game\Application\Enum\WordCount;
use App\Game\Application\Exception\PlayerNotFoundInTokenStorageException;
use App\Game\Application\Service\GamePlay;
use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\SharedKernel\Application\Response\Web\HtmlResponse;
use App\SharedKernel\Application\Response\Web\ResponseInterface;
use App\SharedKernel\Application\Response\Web\TwigResponse;
use Symfony\Component\Routing\Annotation\Route;

final class NewGameAction
{
    private PlayerFromTokenExtractor $extractor;

    public function __construct(PlayerFromTokenExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    #[Route('/game/play', name: 'web.game.play.view', methods: ['GET'])]
    public function __invoke(GamePlay $game): ResponseInterface
    {
        try {
            $playerDto = $this->extractor->player();
        } catch (PlayerNotFoundInTokenStorageException) {
            return new HtmlResponse('Login session is over.');
        }

        $gameDto = $game->new('en', Type::byRole($playerDto->role()), WordCount::byLevel($playerDto->level()));

        return new TwigResponse('@game/play.html.twig', [
            'player' => $playerDto,
            'game' => $gameDto,
        ]);
    }
}
