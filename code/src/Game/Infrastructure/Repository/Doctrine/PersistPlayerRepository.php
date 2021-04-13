<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Dto\PlayerRegistrationDto;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Repository\PersistPlayerRepositoryInterface;
use App\Game\Domain\Service\PasswordEncoderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

final class PersistPlayerRepository extends ServiceEntityRepository implements PersistPlayerRepositoryInterface
{
    private PasswordEncoderInterface $encoder;

    public function __construct(ManagerRegistry $registry, PasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, Player::class);
        $this->encoder = $encoder;
    }

    public function createPlayer(UuidInterface $uuid, PlayerRegistrationDto $playerDto): void
    {
        $player = new Player($uuid);
        $player->changeNickname($playerDto->nickname());
        $player->changeLevel($playerDto->level());
        $player->changeRole($playerDto->role());
        $player->changePassword($this->encoder->encodePassword($playerDto->password(), null));

        $this->store($player);
    }

    private function store(Player $player): void
    {
        $em = $this->getEntityManager();
        $em->persist($player);
        $em->flush();
    }
}
