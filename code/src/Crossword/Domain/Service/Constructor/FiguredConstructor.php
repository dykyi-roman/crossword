<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Model\Crossword;

final class FiguredConstructor implements ConstructorInterface
{
    public function build(string $language, int $wordCount): Crossword
    {
        return new Crossword();
    }
}
