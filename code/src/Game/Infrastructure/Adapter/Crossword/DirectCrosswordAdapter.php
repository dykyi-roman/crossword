<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Crossword\Features\Receiver\CrosswordReceiver;
use App\Game\Features\GamePlay\Crossword\CrosswordCriteria;
use App\Game\Features\GamePlay\Crossword\CrosswordDto;
use App\Game\Features\GamePlay\Crossword\CrosswordInterface;

final class DirectCrosswordAdapter implements CrosswordInterface
{
    private CrosswordReceiver $crosswordReceiver;

    public function __construct(CrosswordReceiver $crosswordReceiver)
    {
        $this->crosswordReceiver = $crosswordReceiver;
    }

    public function construct(CrosswordCriteria $criteria): CrosswordDto
    {
        $key = sprintf('%s-%s-%d', $criteria->language(), $criteria->type(), $criteria->wordCount());

        return new CrosswordDto([
            'success' => true,
            'data' => $this->crosswordReceiver->receive($key),
        ]);
    }
}
