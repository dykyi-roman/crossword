<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Answer;

use App\Game\Application\Service\PlayerFromTokenExtractor;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Repository\PersistHistoryRepositoryInterface;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;

final class Answers
{
    private AnswersValidator $answersValidator;
    private PlayerFromTokenExtractor $playerFromTokenExtractor;
    private PersistPlayerRepositoryInterface $persistPlayerRepository;
    private PersistHistoryRepositoryInterface $persistHistoryRepository;

    public function __construct(
        AnswersValidator $answersValidator,
        PlayerFromTokenExtractor $playerFromTokenExtractor,
        PersistPlayerRepositoryInterface $persistPlayerRepository,
        PersistHistoryRepositoryInterface $persistHistoryRepository
    ) {
        $this->answersValidator = $answersValidator;
        $this->persistPlayerRepository = $persistPlayerRepository;
        $this->playerFromTokenExtractor = $playerFromTokenExtractor;
        $this->persistHistoryRepository = $persistHistoryRepository;
    }

    public function __invoke(array $payload)
    {
        $playerDto = $this->playerFromTokenExtractor->player();
        $this->answersValidator->validate($payload);
        $this->persistPlayerRepository->levelUp($playerDto->id());

        $this->persistHistoryRepository->createHistory(
            $playerDto->id(),
            $playerDto->id(),
            Level::levelUp($playerDto->level())
        );
    }
}
