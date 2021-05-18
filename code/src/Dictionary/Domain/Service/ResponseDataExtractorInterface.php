<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use Psr\Http\Message\ResponseInterface;

interface ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array;
}
