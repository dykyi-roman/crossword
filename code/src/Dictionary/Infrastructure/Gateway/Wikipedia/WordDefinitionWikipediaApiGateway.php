<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway\Wikipedia;

use App\Dictionary\Infrastructure\Gateway\AbstractWordDefinition;
use App\Dictionary\Infrastructure\HttpClient\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class WordDefinitionWikipediaApiGateway extends AbstractWordDefinition
{
    private const URI = 'https://%s.%s?action=query&format=json&titles=%s&prop=extracts&exintro&explaintext';

    private string $wikipediaApiHost;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $wikipediaApiHost
    ) {
        $this->wikipediaApiHost = $wikipediaApiHost;
        $this->client = $client;
        $this->responseDataExtractor = $responseDataExtractor;
    }

    public function search(string $word, string $language): string
    {
        $uri = sprintf(self::URI, $language, $this->wikipediaApiHost, $word);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));
            $payload = $this->responseDataExtractor->extract($response);
            $wikipediaWordDefinitionDto = new WikipediaWordDefinitionDto($payload);

            return null === $wikipediaWordDefinitionDto->word() ?
                parent::search($word, $language) :
                str_replace($word, '___', $wikipediaWordDefinitionDto->word());
        } catch (Throwable) {
            return parent::search($word, $language);
        }
    }
}
