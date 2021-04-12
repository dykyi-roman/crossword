<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Dto\PlayerLoginDto;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use App\Game\Domain\Service\PasswordEncoderInterface;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ReadPlayerRepository extends ServiceEntityRepository implements ReadPlayerRepositoryInterface
{
    private PasswordEncoderInterface $encoder;

    public function __construct(ManagerRegistry $registry, PasswordEncoderInterface $encoder)
    {
        parent::__construct($registry, Player::class);
        $this->encoder = $encoder;
    }

    public function login(string $nickname, string $password): PlayerLoginDto
    {
        $player = $this->createQueryBuilder('u')
            ->andWhere('u.nickname = :nickname')
            ->andWhere('u.password = :password')
            ->setParameters([
                'nickname' => $nickname,
                'password' => $this->encoder->encodePassword($password, null),
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if (!$player instanceof Player) {
            throw new PlayerNotFoundException();
        }

        return new PlayerLoginDto($player->nickname(), $player->level(), $player->role());
    }
}
