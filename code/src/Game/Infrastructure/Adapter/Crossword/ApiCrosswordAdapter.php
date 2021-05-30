<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Game\Features\GamePlay\Crossword\ApiClientException;
use App\Game\Features\GamePlay\Crossword\CrosswordCriteria;
use App\Game\Features\GamePlay\Crossword\CrosswordDto;
use App\Game\Features\GamePlay\Crossword\CrosswordInterface;
use App\Game\Infrastructure\HttpClient\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class ApiCrosswordAdapter implements CrosswordInterface
{
    private string $crosswordApiHost;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $crosswordApiHost
    ) {
        $this->client = $client;
        $this->crosswordApiHost = $crosswordApiHost;
        $this->responseDataExtractor = $responseDataExtractor;
    }

    public function construct(CrosswordCriteria $criteria): CrosswordDto
    {
        $uri = sprintf(
            '%s/construct/%s/%s/%d',
            $this->crosswordApiHost,
            $criteria->language(),
            $criteria->type(),
            $criteria->wordCount()
        );

        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new CrosswordDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ApiClientException::badRequest($exception->getMessage());
        }
    }
}
