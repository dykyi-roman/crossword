<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization;

use App\Game\Features\Authorization\Repository\ReadPlayerRepositoryInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class PlayerLogin
{
    private LoggerInterface $logger;
    private PlayerTokenHack $playerToken;
    private ReadPlayerRepositoryInterface $readPlayerRepository;

    public function __construct(
        LoggerInterface $logger,
        PlayerTokenHack $playerToken,
        ReadPlayerRepositoryInterface $readPlayerRepository
    ) {
        $this->logger = $logger;
        $this->playerToken = $playerToken;
        $this->readPlayerRepository = $readPlayerRepository;
    }

    /**
     * @throws PlayerLoginException
     */
    public function __invoke(string $nickname, string $password): void
    {
        try {
            $playerDto = $this->readPlayerRepository->findPlayerByNicknameAndPassword($nickname, $password);
            $this->playerToken->refresh($playerDto);

            return;
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new PlayerLoginException();
    }
}
