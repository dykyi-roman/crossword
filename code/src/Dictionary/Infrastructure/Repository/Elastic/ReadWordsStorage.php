<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Features\Languages\Storage\LanguageStorageInterface;
use App\Dictionary\Features\Languages\Storage\NotFoundSupportedLanguagesException;
use App\Dictionary\Features\WordsFinder\Mask\Mask;
use App\Dictionary\Features\WordsFinder\Storage\ReadWordsStorageInterface;
use App\Dictionary\Features\WordsFinder\Storage\WordNotFoundInStorageException;
use App\Dictionary\Features\WordsFinder\Word\Word;
use App\Dictionary\Features\WordsFinder\Word\WordDto;
use App\Dictionary\Features\WordsFinder\Word\WordDtoCollection;
use Elasticsearch\Client;
use Throwable;

final class ReadWordsStorage implements ReadWordsStorageInterface, LanguageStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function search(string $language, Mask $mask, int $limit): WordDtoCollection
    {
        $params = [
            'index' => $language,
            'body' => [
                'size' => $limit,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'regexp' => [
                                    'word' => $mask->query(),
                                ],
                            ],
                            [
                                'regexp' => [
                                    'word' => '.' . $mask->limit(),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $collection = $this->doSearch($params, $limit);
            if ($collection->count()) {
                return $collection;
            }

            throw new WordNotFoundInStorageException((string) $mask, $language);
        } catch (Throwable) {
            throw new WordNotFoundInStorageException((string) $mask, $language);
        }
    }

    private function doSearch(array $params, int $limit): WordDtoCollection
    {
        $response = $this->client->search($params);
        shuffle($response['hits']['hits']);

        $words = [];
        $wordDtoCollection = new StorageWordDtoCollection(array_slice($response['hits']['hits'], 0, $limit));
        foreach ($wordDtoCollection as $word) {
            $words[] = new WordDto($word->language(), new Word($word->word(), $word->definition()));
        }

        return new WordDtoCollection(...$words);
    }

    public function language(): array
    {
        $indexes = $this->client->indices();

        $languages = array_keys($indexes->getSettings());

        return count($languages) ? $languages : throw new NotFoundSupportedLanguagesException();
    }
}
