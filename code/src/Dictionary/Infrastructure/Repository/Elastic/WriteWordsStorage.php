<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use App\Dictionary\Domain\Exception\FailedSaveToStorageException;
use App\Dictionary\Domain\Repository\WriteWordsStorageInterface;
use App\SharedKernel\Domain\Model\Word;
use Elasticsearch\Client;
use Throwable;

final class WriteWordsStorage implements WriteWordsStorageInterface
{
    private Client $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create();
    }

    public function save(string $language, Word $word): void
    {
        try {
            $this->client->index(
                [
                    'index' => $language,
                    'id' => base64_encode($word->value()),
                    'body' => [
                        'word' => $word->value(),
                        'definition' => $word->definition(),
                        'length' => $word->length(),
                    ],
                ]
            );
        } catch (Throwable) {
            throw new FailedSaveToStorageException($word->value(), $language);
        }
    }
}
