<?php

declare(strict_types=1);

namespace App\Game\Domain\Service;

use App\Game\Domain\Dto\PlayerDto;
use JsonException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class PlayerTokenHack
{
    private TokenStorageInterface $tokenStorage;
    private SessionInterface $session;

    public function __construct(TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    /**
     * @throws JsonException
     */
    public function refresh(PlayerDto $playerDto): void
    {
        $token = new UsernamePasswordToken(json_encode($playerDto, JSON_THROW_ON_ERROR), null, 'main');
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
    }
}
