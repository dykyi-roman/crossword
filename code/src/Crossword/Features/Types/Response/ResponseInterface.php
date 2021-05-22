<?php

declare(strict_types=1);

namespace App\Crossword\Features\Types\Response;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
