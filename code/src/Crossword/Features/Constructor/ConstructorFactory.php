<?php

declare(strict_types=1);

namespace App\Crossword\Features\Constructor;

use App\Crossword\Features\Constructor\Figured\FiguredConstructor;
use App\Crossword\Features\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Features\Constructor\Normal\NormalConstructor;
use App\Crossword\Features\Constructor\Scanner\GridScanner;
use App\Crossword\Features\Constructor\Scanner\RowXScanner;
use App\Crossword\Features\Constructor\Scanner\RowYScanner;
use App\Crossword\Features\Constructor\Type\Type;

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
