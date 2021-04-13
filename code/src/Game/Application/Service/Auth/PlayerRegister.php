<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Auth;

use App\Game\Application\Criteria\PlayerRegisterCriteria;
use App\Game\Domain\Dto\PlayerRegistrationDto;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;
use Ramsey\Uuid\Uuid;

final class PlayerRegister
{
    private PersistPlayerRepositoryInterface $persistUserRepository;

    public function __construct(PersistPlayerRepositoryInterface $persistUserRepository)
    {
        $this->persistUserRepository = $persistUserRepository;
    }

    public function execute(PlayerRegisterCriteria $criteria): void
    {
        $this->persistUserRepository->createPlayer(
            Uuid::uuid4(),
            new PlayerRegistrationDto(
                $criteria->nickname(),
                $criteria->password(),
                Level::startLevel(),
                $criteria->role(),
            ),
        );
    }
}
