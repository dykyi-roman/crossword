<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Application\Dto\StorageWordCollectionDto;
use App\Dictionary\Application\Dto\StorageWordDto;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Model\WordCollection;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;
use Elasticsearch\Client;
use Throwable;

final class ReadWordsStorage implements ReadWordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function search(string $language, string $mask, int $limit): WordCollection
    {
        $params = [
            'index' => $language,
            'body' => [
                'query' => [
                    'regexp' => [
                        'word' => $mask,
                    ],
                ],
            ],
        ];

        try {
            $collection = $this->doSearch($params, $limit);

            return count($collection) ? $collection : throw new WordNotFoundInStorageException($mask, $language);
        } catch (Throwable) {
            throw new WordNotFoundInStorageException($mask, $language);
        }
    }

    public function doSearch(array $params, int $limit): WordCollection
    {
        $response = $this->client->search($params);
        shuffle($response['hits']['hits']);
        $wordCollection = new WordCollection();
        array_map(
            static fn (StorageWordDto $word) => $wordCollection->add(
                new Word($word->language(), $word->word(), $word->definition())
            ),
            (new StorageWordCollectionDto(array_slice($response['hits']['hits'], 0, $limit)))->words()
        );

        return $wordCollection;
    }

    public function language(): array
    {
        $indexes = $this->client->indices();

        return array_keys($indexes->getSettings());
    }
}
