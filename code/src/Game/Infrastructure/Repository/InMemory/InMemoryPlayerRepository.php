<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\InMemory;

use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Dto\RegisteredPlayerDto;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;
use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;

final class InMemoryPlayerRepository implements PersistPlayerRepositoryInterface, ReadPlayerRepositoryInterface
{
    /**
     * @var Player[]
     */
    private array $players;

    public function __construct(Player ...$player)
    {
        $this->players = array_reduce(
            $player,
            static function (array $players, Player $player): array {
                $players[(string) $player->playerId()] = $player;

                return $players;
            },
            []
        );
    }

    public function createPlayer(RegisteredPlayerDto $playerDto): void
    {
        $player = new Player($playerDto->playerId());
        $player->changeNickname($playerDto->nickname());
        $player->changeLevel($playerDto->level());
        $player->changeRole($playerDto->role());

        $this->players[(string) $playerDto->playerId()] = $player;
    }

    public function levelUp(PlayerId $playerId): void
    {
        if (array_key_exists((string) $playerId, $this->players)) {
            $player = $this->players[(string) $playerId];
            $this->players[(string) $playerId]->changeLevel(new Level($player->level()->getValue() + 1));

            return;
        }

        throw new PlayerNotFoundException();
    }

    public function findPlayerById(PlayerId $playerId): PlayerDto
    {
        if (!array_key_exists((string) $playerId, $this->players)) {
            throw new PlayerNotFoundException();
        }

        $player = $this->players[(string) $playerId];

        return new PlayerDto($playerId, $player->nickname(), $player->level(), $player->role());
    }

    public function findPlayerByNicknameAndPassword(string $nickname, string $password): PlayerDto
    {
        foreach ($this->players as $player) {
            if ($nickname === $player->nickname() && $password === $player->password()) {
                return new PlayerDto($player->playerId(), $player->nickname(), $player->level(), $player->role());
            }
        }

        throw new PlayerNotFoundException();
    }

    /**
     * @return Player[]
     */
    public function players(): array
    {
        return $this->players;
    }
}
