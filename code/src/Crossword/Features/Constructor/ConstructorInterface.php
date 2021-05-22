<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\Normal\NextLineFoundException;

interface ConstructorInterface
{
    /**
     * @throws NextLineFoundException
     */
    public function build(string $language, int $wordCount): CrosswordDto;
}
