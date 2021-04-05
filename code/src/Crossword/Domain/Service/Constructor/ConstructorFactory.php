<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Constructor;

use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Service\Constructor\Normal\AttemptWordFinder;
use App\Crossword\Domain\Service\GridScanner;
use App\Crossword\Domain\Service\WordFinder;

final class ConstructorFactory
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
                new GridScanner(new Grid())
            ),
            Type::FIGURED => new FiguredConstructor(),
        };
    }
}
