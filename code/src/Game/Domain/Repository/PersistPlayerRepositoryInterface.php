<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\NewPlayerDto;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface PersistPlayerRepositoryInterface
{
    public function createPlayer(NewPlayerDto $playerDto): void;

    /**
     * @throws PlayerNotFoundException
     */
    public function levelUp(UuidInterface $uuid): void;
}
