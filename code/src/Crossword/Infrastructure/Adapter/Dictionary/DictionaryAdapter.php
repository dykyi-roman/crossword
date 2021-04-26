<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Domain\Dto\DictionaryLanguagesDto;
use App\Crossword\Domain\Dto\DictionaryWordDto;
use App\Crossword\Domain\Exception\ApiClientException;
use App\Crossword\Domain\Port\DictionaryInterface;
use App\SharedKernel\Domain\Service\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class DictionaryAdapter implements DictionaryInterface
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

    public function searchWord(string $language, string $mask): DictionaryWordDto
    {
        $uri = sprintf('%s/words/%s/?mask=%s', $this->dictionaryApiHost, $language, $mask);
        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new DictionaryWordDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ApiClientException::badRequest($exception->getMessage());
        }
    }
}
