<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Game\Features\GamePlay\Crossword\ApiClientException;
use App\Game\Features\GamePlay\Crossword\CrosswordCriteria;
use App\Game\Features\GamePlay\Crossword\CrosswordDto;
use App\Game\Features\GamePlay\Crossword\CrosswordInterface;

final class InMemoryCrosswordAdapter implements CrosswordInterface
{
    private null | CrosswordDto $crosswordDto;

    public function __construct(null | CrosswordDto $crosswordDto)
    {
        $this->crosswordDto = $crosswordDto;
    }

    public function construct(CrosswordCriteria $criteria): CrosswordDto
    {
        if (null === $this->crosswordDto) {
            throw ApiClientException::badRequest('test error message');
        }

        return $this->crosswordDto;
    }
}
