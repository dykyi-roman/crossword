<?php

declare(strict_types=1);

namespace App\Game\Features\History;

use App\Game\Features\History\Response\ResponseInterface;
use App\Game\Features\History\Response\SuccessApiResponse;

final class PlayerRatingAction
{
    public function __invoke(PlayerHistory $playerHistory): ResponseInterface
    {
        return new SuccessApiResponse($playerHistory());
    }
}
