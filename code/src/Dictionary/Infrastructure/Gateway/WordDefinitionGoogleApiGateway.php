<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway;

use App\Shared\Domain\Service\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class WordDefinitionGoogleApiGateway extends AbstractWordDefinition
{
    private string $host;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $host
    ) {
        $this->host = $host;
        $this->client = $client;
        $this->responseDataExtractor = $responseDataExtractor;
    }

    public function find(string $word, string $language): string
    {
        try {
            $uri = sprintf('https://%s/%s/%s', $this->host, $language, $word);
            $response = $this->client->sendRequest(new Request('GET', $uri));
            $payload = $this->responseDataExtractor->extract($response);
            if (array_key_exists('resolution', $payload) && array_key_exists('message', $payload)) {
                return parent::find($word, $language);
            }

            return $payload[0]['meanings'][0]['definitions'][0]['definition'];
        } catch (Throwable $exception) {
            return parent::find($word, $language);
        }
    }
}
