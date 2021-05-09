<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Service\Constructor\Figured\FiguredConstructor;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\Constructor\Normal\NormalConstructor;
use App\Crossword\Domain\Service\Scanner\GridScanner;
use App\Crossword\Domain\Service\Scanner\RowXScanner;
use App\Crossword\Domain\Service\Scanner\RowYScanner;
use App\Crossword\Domain\Service\WordFinder;

class ConstructorFactory
{
    private WordFinder $wordFinder;

    public function __construct(WordFinder $wordFinder)
    {
        $this->wordFinder = $wordFinder;
    }

    public function create(Type $type): ConstructorInterface
    {
        return match ((string) $type->getValue()) {
            Type::NORMAL => new NormalConstructor(
                new AttemptWordFinder($this->wordFinder),
                new GridScanner(new RowXScanner(), new RowYScanner())
            ),
            Type::FIGURED => new FiguredConstructor(),
        };
    }
}
