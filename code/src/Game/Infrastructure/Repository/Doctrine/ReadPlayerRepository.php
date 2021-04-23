<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Repository\Doctrine;

use App\Game\Domain\Assembler\PlayerAssembler;
use App\Game\Domain\Dto\PlayerDto;
use App\Game\Domain\Model\Player;
use App\Game\Domain\Model\PlayerId;
use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use App\Game\Domain\Service\PasswordEncoderInterface;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findPlayerById(PlayerId $playerId): PlayerDto
    {
        $id = $playerId->id();
        $player = $this->createQueryBuilder('u')
            ->andWhere('u.playerId = :id')
            ->setParameter('id', $id->toString())
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
