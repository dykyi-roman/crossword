<?php

declare(strict_types=1);

namespace App\Game\Features\Answers;

use App\Game\Features\Answers\Authentication\PlayerFromTokenExtractor;
use Symfony\Component\Messenger\MessageBusInterface;

final class Answers
{
    private AnswersValidator $answersValidator;
    private PlayerFromTokenExtractor $playerFromTokenExtractor;
    private MessageBusInterface $messageBus;

    public function __construct(
        AnswersValidator $answersValidator,
        PlayerFromTokenExtractor $playerFromTokenExtractor,
        MessageBusInterface $messageBus
    ) {
        $this->answersValidator = $answersValidator;
        $this->playerFromTokenExtractor = $playerFromTokenExtractor;
        $this->messageBus = $messageBus;
    }

    public function __invoke(array $payload)
    {
        $player = $this->playerFromTokenExtractor->player();
        $this->answersValidator->validate($payload);

        $this->messageBus->dispatch(new CrosswordPuzzleSolvedEvent($player->id(), $player->level()));
    }
}
