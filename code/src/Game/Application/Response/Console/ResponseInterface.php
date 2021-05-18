<?php

declare(strict_types=1);

namespace App\Game\Application\Response\Console;

interface ResponseInterface
{
    public function __invoke(string $message): void;
}
