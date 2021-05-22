<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Adapter\Dictionary;

use App\Crossword\Features\Constructor\Dictionary\ApiClientException as ConstructorApiClientException;
use App\Crossword\Features\Constructor\Dictionary\DictionarySearchInterface;
use App\Crossword\Features\Constructor\Dictionary\DictionaryWordDto;
use App\Crossword\Features\Constructor\Dictionary\WordSearchCriteria;
use App\Crossword\Features\Languages\Dictionary\ApiClientException as LanguagesApiClientException;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesDto;
use App\Crossword\Features\Languages\Dictionary\DictionaryLanguagesInterface;
use App\Crossword\Infrastructure\HttpClient\ResponseDataExtractorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Throwable;

final class ApiDictionaryAdapter implements DictionaryLanguagesInterface, DictionarySearchInterface
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
            throw LanguagesApiClientException::badRequest($exception->getMessage());
        }
    }

    public function searchWord(WordSearchCriteria $criteria): DictionaryWordDto
    {
        $uri = sprintf(
            '%s/words/%s/?mask=%s',
            $this->dictionaryApiHost,
            $criteria->language(),
            $criteria->mask()
        );

        try {
            $response = $this->client->sendRequest(new Request('GET', $uri));

            return new DictionaryWordDto($this->responseDataExtractor->extract($response));
        } catch (Throwable $exception) {
            throw ConstructorApiClientException::badRequest($exception->getMessage());
        }
    }
}
