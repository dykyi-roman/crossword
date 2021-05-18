<?php

declare(strict_types=1);

namespace App\Game\Domain\Service;

use Psr\Http\Message\ResponseInterface;

interface ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array;
}
