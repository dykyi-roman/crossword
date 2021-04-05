<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Application\Dto\StorageWordCollectionDto;
use App\Dictionary\Application\Dto\StorageWordDto;
use App\Dictionary\Domain\Dto\WordCollectionDto;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;
use App\SharedKernel\Domain\Model\Mask;
use Elasticsearch\Client;
use Throwable;

final class ReadWordsStorage implements ReadWordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function search(string $language, Mask $mask, int $limit): WordCollectionDto
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
            $collection =  new WordCollectionDto(...$this->doSearch($params, $limit));
            if ($collection->count()) {
                return $collection;
            }

            throw new WordNotFoundInStorageException((string) $mask, $language);
        } catch (Throwable) {
            throw new WordNotFoundInStorageException((string) $mask, $language);
        }
    }

    public function doSearch(array $params, int $limit): array
    {
        $response = $this->client->search($params);
        shuffle($response['hits']['hits']);

        return array_map(
            static fn (StorageWordDto $word) => new Word($word->language(), $word->word(), $word->definition()),
            (new StorageWordCollectionDto(array_slice($response['hits']['hits'], 0, $limit)))->words()
        );
    }

    public function language(): array
    {
        $indexes = $this->client->indices();

        return array_keys($indexes->getSettings());
    }
}
