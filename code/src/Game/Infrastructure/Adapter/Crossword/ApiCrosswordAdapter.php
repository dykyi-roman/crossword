<?php

declare(strict_types=1);

namespace App\Game\Infrastructure\Adapter\Crossword;

use App\Game\Domain\Dto\CrosswordDto;
use App\Game\Domain\Dto\LanguagesDto;
use App\Game\Domain\Exception\ApiClientException;
use App\Game\Domain\Port\CrosswordInterface;
use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
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

    public function construct(string $language, string $type, int $wordCount): CrosswordDto
    {
        $uri = sprintf('%s/construct/%s/%s/%d', $this->crosswordApiHost, $language, $type, $wordCount);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new CrosswordDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ApiClientException::badRequest($exception->getMessage());
        }
    }

    public function supportedLanguages(): LanguagesDto
    {
        $uri = sprintf('%s/languages', $this->crosswordApiHost);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new LanguagesDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ApiClientException::badRequest($exception->getMessage());
        }
    }
}
