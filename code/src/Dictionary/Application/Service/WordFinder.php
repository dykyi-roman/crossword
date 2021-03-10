<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Service;

use App\Dictionary\Application\Request\WordRequest;
use App\Dictionary\Domain\Dto\ResponseInterface;
use App\Dictionary\Domain\Dto\SuccessResponse;

final class WordFinder
{
    public function findByRequest(WordRequest $request): ResponseInterface
    {
        return new SuccessResponse(['word' => 'test']);
    }
}
