<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Model\Crossword;

interface ConstructorInterface
{
    public function build(string $language, int $wordCount): Crossword;
}
