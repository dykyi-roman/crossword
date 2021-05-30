<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Features\Player\Level\PlayerLevelRepositoryInterface;
use App\Game\Features\Player\Player\Player;
use App\Game\Features\Player\Player\PlayerId;
use App\Game\Features\Player\Player\PlayerNotFoundException;
use App\Game\Features\Registration\PlayerRepositoryInterface;
use App\Game\Features\Registration\Player\PlayerDto;
use App\Game\Infrastructure\Encoder\PasswordEncoderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PersistPlayerRepository extends ServiceEntityRepository implements
    PlayerRepositoryInterface,
    PlayerLevelRepositoryInterface
{
    private PasswordEncoderInterface $encoder;

    public function __construct(ManagerRegistry $registry, PasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, Player::class);
        $this->encoder = $encoder;
    }

    public function createPlayer(PlayerDto $playerDto): void
    {
        $player = new Player(new PlayerId($playerDto->playerId()->id()));
        $player->changeNickname($playerDto->nickname());
        $player->changeRole($playerDto->role()->getValue());
        $player->changePassword($this->encoder->encodePassword($playerDto->password(), null));

        $this->store($player);
    }

    public function changeLevel(PlayerId $playerId): void
    {
        $player = $this->createQueryBuilder('u')
            ->andWhere('u.playerId = :id')
            ->setParameter('id', (string) $playerId)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$player instanceof Player) {
            throw new PlayerNotFoundException();
        }

        $player->changeLevel($player->level() + 1);

        $this->store($player);
    }

    private function store(Player $player): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($player);
        $entityManager->flush($player);
    }
}
