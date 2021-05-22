<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Repository\Redis;

use App\Crossword\Features\Constructor\CrosswordDto;
use App\Crossword\Features\Constructor\PersistCrosswordRepositoryInterface;
use App\Crossword\Infrastructure\Cache\CacheItem;
use Psr\Cache\CacheItemPoolInterface;

final class PersistCrosswordRepository implements PersistCrosswordRepositoryInterface
{
    private CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }

    public function save(string $key, CrosswordDto $crosswordDto): void
    {
        $this->cacheItemPool->save(new CacheItem($key, json_encode($crosswordDto, JSON_THROW_ON_ERROR)));
    }
}
