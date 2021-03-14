<?php

declare(strict_types=1);

namespace App\Shared\Application\Response;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
