<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Service;

use JsonException;
use Psr\Http\Message\ResponseInterface;

interface ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array;
}
