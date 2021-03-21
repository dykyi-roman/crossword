<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Provider;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Provider\DictionaryProviderInterface;
use App\Crossword\Infrastructure\Provider\Exception\ApiClientException;
use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class DictionaryProvider implements DictionaryProviderInterface
{
    private string $dictionaryApiHost;
    private ClientInterface $client;
    private ResponseDataExtractorInterface $responseDataExtractor;

    public function __construct(
        ClientInterface $client,
        ResponseDataExtractorInterface $responseDataExtractor,
        string $dictionaryApiHost
    ) {
        $this->client = $client;
        $this->dictionaryApiHost = $dictionaryApiHost;
        $this->responseDataExtractor = $responseDataExtractor;
    }

    public function supportedLanguages(): DictionaryLanguagesDto
    {
        $uri = sprintf('%s/languages', $this->dictionaryApiHost);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new DictionaryLanguagesDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ApiClientException::badRequest($exception->getMessage());
        }
    }
}
