<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\InMemory;

use App\Game\Features\Authorization\PlayerDto as AuthorizationPlayerDto;
use App\Game\Features\Authorization\Repository\ReadPlayerRepositoryInterface;
use App\Game\Features\Player\Level\PlayerLevelRepositoryInterface;
use App\Game\Features\Player\Player\Player;
use App\Game\Features\Player\Player\PlayerId as PlayerPlayerId;
use App\Game\Features\Player\Player\PlayerNotFoundException;
use App\Game\Features\Player\Player\Role;
use App\Game\Features\Registration\Player\PlayerDto as RegistrationPlayerDto;
use App\Game\Features\Registration\PlayerRepositoryInterface;
use Symfony\Component\Uid\UuidV4;

final class InMemoryPlayerRepository implements
    PlayerRepositoryInterface,
    PlayerLevelRepositoryInterface,
    ReadPlayerRepositoryInterface
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

    public function createPlayer(RegistrationPlayerDto $playerDto): void
    {
        $player = new Player(new PlayerPlayerId($playerDto->playerId()->id()));
        $player->changeNickname($playerDto->nickname());
        $player->changeRole(new Role($playerDto->role()->getValue()));

        $this->players[(string) $playerDto->playerId()] = $player;
    }

    public function changeLevel(PlayerPlayerId $playerId): void
    {
        if (array_key_exists((string) $playerId, $this->players)) {
            $player = $this->players[(string) $playerId];
            $this->players[(string) $playerId]->changeLevel($player->level() + 1);

            return;
        }

        throw new PlayerNotFoundException();
    }

    public function findPlayerById(UuidV4 $playerId): AuthorizationPlayerDto
    {
        if (!array_key_exists((string) $playerId, $this->players)) {
            throw new PlayerNotFoundException();
        }

        $player = $this->players[(string) $playerId];

        return new AuthorizationPlayerDto(
            $playerId,
            $player->nickname(),
            $player->level(),
            $player->role()->getValue()
        );
    }

    public function findPlayerByNicknameAndPassword(string $nickname, string $password): AuthorizationPlayerDto
    {
        foreach ($this->players as $player) {
            if ($nickname === $player->nickname() && $password === $player->password()) {
                return new AuthorizationPlayerDto(
                    $player->playerId()->id(),
                    $player->nickname(),
                    $player->level(),
                    $player->role()->getValue()
                );
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
