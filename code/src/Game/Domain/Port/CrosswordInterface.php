<?php

declare(strict_types=1);

namespace App\Game\Domain\Port;

use App\Game\Domain\Criteria\CrosswordCriteria;
use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Exception\ApiClientException;

interface CrosswordInterface
{
    /**
     * @throws ApiClientException
     */
    public function construct(CrosswordCriteria $criteria): CrosswordDto;
}
