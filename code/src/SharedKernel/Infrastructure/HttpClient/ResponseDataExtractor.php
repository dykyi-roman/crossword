<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient;

use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseDataExtractor implements ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array
    {
        $responseBody = (string) $response->getBody()->getContents();

        return (array) json_decode($responseBody, true);
    }
}
