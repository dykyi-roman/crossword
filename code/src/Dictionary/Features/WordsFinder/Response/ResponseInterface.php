<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Response;

interface ResponseInterface
{
    public function body(): array;

    public function status(): int;
}
