<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway;

use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class WordDefinitionWikipediaApiGateway extends AbstractWordDefinition
{
    private string $host;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;
    private LoggerInterface $logger;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $host,
        LoggerInterface $logger
    ) {
        $this->host = $host;
        $this->client = $client;
        $this->responseDataExtractor = $responseDataExtractor;
        $this->logger = $logger;
    }

    public function search(string $word, string $language): string
    {
        $uri = sprintf(
            'https://%s.%s?action=query&format=json&titles=%s&prop=extracts&exintro&explaintext',
            $language,
            $this->host,
            $word
        );

        try {
            $this->logger->error('send = ' . $word);
            $response = $this->client->sendRequest(new Request('GET', $uri));
            $payload = $this->responseDataExtractor->extract($response);
            $pages = array_values($payload['query']['pages']);
            $text = $pages[0]['extract'];
            if ($text && ((false === stripos($text, 'refer to')) || (false === stripos($text, 'refers to')))) {
                return str_replace($word, '___', (string) explode('.', $text)[0]);
            }

            return parent::search($word, $language);
        } catch (Throwable $exception) {
            return parent::search($word, $language);
        }
    }
}
