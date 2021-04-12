<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Auth;

use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use App\Game\Infrastructure\Repository\Exception\PlayerNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class Login
{
    private LoggerInterface $logger;
    private SessionInterface $session;
    private ReadPlayerRepositoryInterface $readPlayerRepository;

    public function __construct(
        ReadPlayerRepositoryInterface $readPlayerRepository,
        SessionInterface $session,
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
        $this->readPlayerRepository = $readPlayerRepository;
        $this->session = $session;
    }

    public function execute(string $nickname, string $password): bool
    {
        try {
            $playerDto = $this->readPlayerRepository->login($nickname, $password);

            $this->session->set('player', $playerDto->jsonSerialize());
            $this->session->save();

            return true;
        } catch (PlayerNotFoundException $exception) {
            $this->logger->error($exception->getMessage());
        }

        return false;
    }
}
