<?php

declare(strict_types=1);

namespace App\Crossword\Infrastructure\Repository\Redis;

use App\Crossword\Features\Receiver\CrosswordNotFoundException;
use App\Crossword\Features\Receiver\ReadCrosswordRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;

final class ReadCrosswordRepository implements ReadCrosswordRepositoryInterface
{
    private CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;
    }

    public function get(string $key): array
    {
        $item = $this->cacheItemPool->getItem($key);
        if ($item->isHit()) {
            $list = array_values($item->get());
            shuffle($list);

            return json_decode(array_shift($list), true, 512, JSON_THROW_ON_ERROR);
        }

        throw new CrosswordNotFoundException(sprintf('Crossword not found in the storage. Search key: "%s"', $key));
    }
}
