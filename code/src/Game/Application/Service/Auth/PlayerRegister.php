<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Auth;

use App\Game\Application\Criteria\PlayerRegisterCriteria;
use App\Game\Domain\Dto\NewPlayerDto;
use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;

final class PlayerRegister
{
    private PersistPlayerRepositoryInterface $persistUserRepository;

    public function __construct(PersistPlayerRepositoryInterface $persistUserRepository)
    {
        $this->persistUserRepository = $persistUserRepository;
    }

    public function execute(PlayerRegisterCriteria $criteria): void
    {
        $playerDto = new PlayerDto(new PlayerId(), $criteria->nickname(), Level::startLevel(), $criteria->role());
        $this->persistUserRepository->createPlayer(new NewPlayerDto($criteria->password(), $playerDto));
    }
}
