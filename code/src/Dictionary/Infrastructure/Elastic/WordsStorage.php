<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Elastic;

use App\Dictionary\Domain\Exception\WordException;
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

    public function find(string $language, string $mask, ?int $length = null): WordCollection
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
            $collection = new WordCollection();
            array_map(
                fn (WordDto $word) => $collection->add(
                    new Word($word->language(), $word->word(), $word->definition())
                ),
                (new WordCollectionDto($response))->words()
            );

            return $collection;
        } catch (Throwable $exception) {
            throw WordException::wordIsNotFound($language, $mask);
        }
    }

    public function write(Word $word): void
    {
        try
        {
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
        }catch (Throwable $exception) {
            throw WordException::failedToWrite($word->language(), $word->word());
        }
    }
}
