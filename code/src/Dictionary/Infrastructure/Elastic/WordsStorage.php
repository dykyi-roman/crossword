<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Elastic;

use App\Dictionary\Application\Dto\StorageWordCollection;
use App\Dictionary\Application\Dto\StorageWord;
use App\Dictionary\Domain\Exception\FailedWriteToStorageException;
use App\Dictionary\Domain\Exception\WordNotFoundInStorageException;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Model\WordCollection;
use App\Dictionary\Domain\Service\WordsStorageInterface;
use Elasticsearch\Client;
use Throwable;

final class WordsStorage implements WordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function search(string $language, string $mask, int $length): WordCollection
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
            $response = $this->client->search($params);
            shuffle($response['hits']['hits']);
            $collection = new WordCollection();
            array_map(
                fn (StorageWord $word) => $collection->add(
                    new Word($word->language(), $word->word(), $word->definition())
                ),
                (new StorageWordCollection(array_slice($response['hits']['hits'], 0, $length)))->words()
            );

            return $collection;
        } catch (Throwable $exception) {
            throw new WordNotFoundInStorageException($mask, $language);
        }
    }

    public function add(Word $word): void
    {
        try {
            $this->client->index(
                [
                    'index' => $word->language(),
                    'id' => base64_encode($word->word()),
                    'body' => [
                        'word' => $word->word(),
                        'definition' => $word->definition(),
                    ],
                ]
            );
        } catch (Throwable $exception) {
            throw new FailedWriteToStorageException($word->word(), $word->language());
        }
    }

    public function language(): array
    {
        return array_keys($this->client->indices()->getSettings());
    }
}
