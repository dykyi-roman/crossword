<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Application\Dto\StorageWordCollectionDto;
use App\Dictionary\Domain\Dto\WordDto;
use App\Dictionary\Domain\Dto\WordsCollectionDto;
use App\Dictionary\Domain\Repository\ReadWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;
use App\SharedKernel\Domain\Model\Mask;
use App\SharedKernel\Domain\Model\Word;
use Elasticsearch\Client;
use Throwable;

final class ReadWordsStorage implements ReadWordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function search(string $language, Mask $mask, int $limit): WordsCollectionDto
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

    private function doSearch(array $params, int $limit): WordsCollectionDto
    {
        $response = $this->client->search($params);
        shuffle($response['hits']['hits']);

        $words = [];
        $wordCollectionDto = new StorageWordCollectionDto(array_slice($response['hits']['hits'], 0, $limit));
        foreach ($wordCollectionDto as $word) {
            $words[] = new WordDto($word->language(), new Word($word->word(), $word->definition()));
        }

        return new WordsCollectionDto(...$words);
    }

    public function language(): array
    {
        $indexes = $this->client->indices();

        return array_keys($indexes->getSettings());
    }
}
