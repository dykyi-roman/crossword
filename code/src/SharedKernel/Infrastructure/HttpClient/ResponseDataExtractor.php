<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient;

use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseDataExtractor implements ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array
    {
        return (array) json_decode($response->getBody()->getContents(), true);
    }
}
