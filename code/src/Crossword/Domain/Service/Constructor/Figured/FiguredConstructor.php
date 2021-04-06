<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor\Figured;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Service\Constructor\ConstructorInterface;

final class FiguredConstructor implements ConstructorInterface
{
    /**
     * @example Swastika, Singapore, Rectangle, NumberFive, Grid, Gate, Cross, Cactus
     */
    public function build(string $language, int $wordCount): CrosswordDto
    {
        return new CrosswordDto();
    }
}
