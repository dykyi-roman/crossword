<?php

declare(strict_types=1);

namespace App\Dictionary\Features\Languages\Response;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
