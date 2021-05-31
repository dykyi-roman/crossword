<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Game\Domain\Criteria\CrosswordCriteria;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Exception\ApiClientException;
use App\Game\Domain\Port\CrosswordInterface;

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
