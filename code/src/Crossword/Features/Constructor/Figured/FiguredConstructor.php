<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor\Figured;

use App\Crossword\Features\Constructor\ConstructorInterface;
use App\Crossword\Features\Constructor\CrosswordDto;

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
