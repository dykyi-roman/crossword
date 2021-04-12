<?php

declare(strict_types=1);

namespace App\Game\Application\Service\Auth;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class Logout
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function execute(): void
    {
        $this->session->set('player', []);
    }
}
