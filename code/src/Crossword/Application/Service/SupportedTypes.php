<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Domain\Enum\Type;

final class SupportedTypes
{
    public function receive(): array
    {
        return array_values(Type::toArray());
    }
}
