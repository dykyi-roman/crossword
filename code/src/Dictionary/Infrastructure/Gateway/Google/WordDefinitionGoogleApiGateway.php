<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway\Google;

use App\Dictionary\Infrastructure\Gateway\AbstractWordDefinition;
use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class WordDefinitionGoogleApiGateway extends AbstractWordDefinition
{
    private string $googleApiHost;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $googleApiHost
    ) {
        $this->googleApiHost = $googleApiHost;
        $this->client = $client;
        $this->responseDataExtractor = $responseDataExtractor;
    }

    public function search(string $word, string $language): string
    {
        $uri = sprintf('https://%s/%s/%s', $this->googleApiHost, $language, $word);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));
            $payload = $this->responseDataExtractor->extract($response);
            $googleWordDefinitionDto = new GoogleWordDefinitionDto($payload);

            return $googleWordDefinitionDto->word() ?? parent::search($word, $language);
        } catch (Throwable) {
            return parent::search($word, $language);
        }
    }
}
