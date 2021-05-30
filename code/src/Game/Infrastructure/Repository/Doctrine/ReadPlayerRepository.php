<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Features\Authorization\PlayerDto;
use App\Game\Features\Authorization\Repository\PlayerNotFoundException;
use App\Game\Features\Authorization\Repository\ReadPlayerRepositoryInterface;
use App\Game\Features\Player\Player\Player;
use App\Game\Infrastructure\Encoder\PasswordEncoderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\UuidV4;

final class ReadPlayerRepository extends ServiceEntityRepository implements ReadPlayerRepositoryInterface
{
    private PlayerAssembler $playerAssembler;
    private PasswordEncoderInterface $encoder;

    public function __construct(
        ManagerRegistry $registry,
        PlayerAssembler $playerAssembler,
        PasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
        $this->playerAssembler = $playerAssembler;

        parent::__construct($registry, Player::class);
    }

    public function findPlayerById(UuidV4 $playerId): PlayerDto
    {
        $player = $this->createQueryBuilder('u')
            ->andWhere('u.playerId = :id')
            ->setParameter('id', (string) $playerId)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$player instanceof Player) {
            throw new PlayerNotFoundException();
        }

        return $this->playerAssembler->toPlayerDto($player);
    }

    public function findPlayerByNicknameAndPassword(string $nickname, string $password): PlayerDto
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

        return $this->playerAssembler->toPlayerDto($player);
    }
}
