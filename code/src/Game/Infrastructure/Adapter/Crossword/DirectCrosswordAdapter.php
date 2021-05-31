<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Crossword\Application\Service\CrosswordReceiver;
use App\Game\Domain\Criteria\CrosswordCriteria;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Port\CrosswordInterface;
use App\SharedKernel\Application\Response\API\SuccessApiResponse;

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
        $data = $this->crosswordReceiver->receive($key);
        $response = new SuccessApiResponse($data);

        return new CrosswordDto($response->body());
    }
}
