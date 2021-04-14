<?php

declare(strict_types=1);

namespace App\Game\Domain\Repository;

use App\Game\Domain\Dto\NewPlayerDto;

interface PersistPlayerRepositoryInterface
{
    public function createPlayer(NewPlayerDto $playerDto): void;
}
