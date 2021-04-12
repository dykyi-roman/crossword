<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\PlayerRegistrationDto;
use Ramsey\Uuid\UuidInterface;

interface PersistPlayerRepositoryInterface //rename to PLAYER domain name
{
    public function registration(UuidInterface $uuid, PlayerRegistrationDto $playerDto): void;
}
