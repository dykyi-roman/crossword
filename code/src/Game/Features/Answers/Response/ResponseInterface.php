<?php

declare(strict_types=1);

namespace App\Game\Features\Answers\Response;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
