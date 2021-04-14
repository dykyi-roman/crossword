<?php

declare(strict_types=1);

namespace App\Game\Application\Service;

use App\Game\Domain\Service\CrosswordConstructor;

final class PlayGame
{
    private CrosswordConstructor $constructor;

    public function __construct(CrosswordConstructor $constructor)
    {
        $this->constructor = $constructor;
    }

    public function play(): array
    {
        dump($this->constructor->construct('en', 'normal', 3));
        die();
    }
}
