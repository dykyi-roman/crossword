<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\HttpClient;

use App\Dictionary\Domain\Service\ResponseDataExtractorInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseDataExtractor implements ResponseDataExtractorInterface
{
    public function extract(ResponseInterface $response): array
    {
        $responseBody = (string) $response->getBody()->getContents();

        return (array) json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
    }
}
