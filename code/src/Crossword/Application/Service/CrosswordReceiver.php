<?php

declare(strict_types=1);

namespace App\Crossword\Application\Service;

use App\Crossword\Application\Exception\ReceiveCrosswordException;
use App\Crossword\Domain\Enum\Type;
use JsonException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class CrosswordReceiver
{
    private LoggerInterface $logger;
    private CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * @throws ReceiveCrosswordException
     */
    public function receive(Type $type, string $language, int $wordCount): array
    {
        try {
            return $this->doReceive($type, $language, $wordCount);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        throw new ReceiveCrosswordException();
    }

    /**
     * @throws JsonException
     */
    private function doReceive(Type $type, string $language, int $wordCount): array
    {
        $key = sprintf('%s-%s-%d', $language, (string) $type->getValue(), $wordCount);
        $item = $this->cacheItemPool->getItem($key);
        if ($item->isHit()) {
            $list = array_values($item->get());
            shuffle($list);

            return json_decode(array_shift($list), true, 512, JSON_THROW_ON_ERROR);
        }

        throw new ReceiveCrosswordException(sprintf('Crossword not found in the storage. Search key: "%s"', $key));
    }
}
