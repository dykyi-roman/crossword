<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Exception\NextLineFoundException;
use App\Crossword\Domain\Model\Crossword;

interface ConstructorInterface
{
    /**
     * @throws NextLineFoundException
     */
    public function build(string $language, int $wordCount): Crossword;
}
