<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Cache;

use Predis\Client;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

final class RedisClient implements CacheItemPoolInterface
{
    /**
     * @var CacheItemInterface[]
     */
    private array $deferred;

    private Client $client;

    public function __construct(string $redisHost, string $redisPort)
    {
        $this->client = new Client([
            'host' => $redisHost,
            'port' => $redisPort,
        ]);

        $this->client->connect();
    }

    public function getItem(string $key): CacheItemInterface
    {
        $value = $this->client->hgetall($key);

        return new CacheItem($key, $value);
    }

    /**
     * @var CacheItemInterface[]
     */
    public function getItems(array $keys = []): array
    {
        return array_map(static fn (string $key) => $this->getItem($key), $keys);
    }

    public function hasItem(string $key): bool
    {
        return $this->getItem($key)->isHit();
    }

    public function clear(): bool
    {
        return (bool) $this->client->flushall();
    }

    public function deleteItem(string $key): bool
    {
        return (bool) $this->client->del($key);
    }

    public function deleteItems(array $keys): bool
    {
        array_map(static fn (string $key) => $this->deleteItem($key), $keys);

        return true;
    }

    public function save(CacheItemInterface $item): bool
    {
        return (bool) $this->client->hset($item->getKey(), time(), $item->get());
    }

    public function saveDeferred(CacheItemInterface $item): bool
    {
        $this->deferred[] = $item;

        return true;
    }

    public function commit(): bool
    {
        array_map(static fn (CacheItemInterface $item) => $this->save($item), $this->deferred);

        return true;
    }
}
