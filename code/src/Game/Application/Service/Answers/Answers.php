<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Answers;

use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;

final class Answers
{
    private AnswersValidator $answersValidator;
    private PlayerFromTokenExtractor $playerFromTokenExtractor;
    private PersistPlayerRepositoryInterface $persistPlayerRepository;

    public function __construct(
        AnswersValidator $answersValidator,
        PlayerFromTokenExtractor $playerFromTokenExtractor,
        PersistPlayerRepositoryInterface $persistPlayerRepository,
    ) {
        $this->answersValidator = $answersValidator;
        $this->persistPlayerRepository = $persistPlayerRepository;
        $this->playerFromTokenExtractor = $playerFromTokenExtractor;
    }

    public function __invoke(array $payload)
    {
        $playerDto = $this->playerFromTokenExtractor->player();
//        $this->answersValidator->validate($payload);

        $level = $playerDto->level();
        if (!$level->equals(Level::finishLevel())) {
            $this->persistPlayerRepository->levelUp($playerDto->playerId());
        }
    }
}
