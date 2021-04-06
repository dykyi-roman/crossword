<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Dto\CrosswordDto;
use App\Crossword\Domain\Exception\NextLineFoundException;

interface ConstructorInterface
{
    /**
     * @throws NextLineFoundException
     */
    public function build(string $language, int $wordCount): CrosswordDto;
}
