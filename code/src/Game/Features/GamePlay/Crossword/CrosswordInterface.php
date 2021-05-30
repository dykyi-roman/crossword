<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

interface CrosswordInterface
{
    /**
     * @throws ApiClientException
     */
    public function construct(CrosswordCriteria $criteria): CrosswordDto;
}
