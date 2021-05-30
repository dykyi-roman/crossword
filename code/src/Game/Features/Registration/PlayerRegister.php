<?php

declare(strict_types=1);

namespace App\Game\Features\Registration;

use App\Game\Features\Registration\Player\PlayerDto;
use App\Game\Features\Registration\Player\PlayerId;

final class PlayerRegister
{
    private PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function execute(PlayerRegisterCriteria $criteria): void
    {
        $playerDto = new PlayerDto(new PlayerId(), $criteria->password(), $criteria->nickname(), $criteria->role());
        $this->playerRepository->createPlayer($playerDto);
    }
}
