<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Repository\WriteWordsStorageInterface;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\FailedSaveToStorageException;
use Elasticsearch\Client;
use Throwable;

final class WriteWordsStorage implements WriteWordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function save(Word $word): void
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
            throw new FailedSaveToStorageException($word->word(), $word->language());
        }
    }
}
