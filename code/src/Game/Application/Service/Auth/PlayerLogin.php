<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Auth;

use App\Game\Application\Exception\PlayerLoginException;
use App\Game\Domain\Repository\ReadPlayerRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Throwable;

final class PlayerLogin
{
    private LoggerInterface $logger;
    private SessionInterface $session;
    private TokenStorageInterface $tokenStorage;
    private ReadPlayerRepositoryInterface $readPlayerRepository;

    public function __construct(
        LoggerInterface $logger,
        SessionInterface $session,
        TokenStorageInterface $tokenStorage,
        ReadPlayerRepositoryInterface $readPlayerRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->readPlayerRepository = $readPlayerRepository;
        $this->logger = $logger;
    }

    /**
     * @throws PlayerLoginException
     */
    public function __invoke(string $nickname, string $password): void
    {
        try {
            $player = $this->readPlayerRepository->findPlayerByNicknameAndPassword($nickname, $password);

            $token = new UsernamePasswordToken(json_encode($player, JSON_THROW_ON_ERROR), null, 'main');
            $this->tokenStorage->setToken($token);
            $this->session->set('_security_main', serialize($token));

            return;
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new PlayerLoginException();
    }
}
