<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response\API;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
