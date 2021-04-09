<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Messages\Handler;

use App\Crossword\Domain\Messages\Message\GenerateCrosswordMessage;
use App\Crossword\Domain\Service\Constructor\ConstructorFactory;
use App\Crossword\Infrastructure\Cache\CacheItem;
use JsonException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateCrosswordMessageHandler implements MessageHandlerInterface
{
    private ConstructorFactory $constructorFactory;
    private CacheItemPoolInterface $cacheItemPool;

    public function __construct(CacheItemPoolInterface $cacheItemPool, ConstructorFactory $constructorFactory)
    {
        $this->constructorFactory = $constructorFactory;
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * @throws JsonException
     */
    public function __invoke(GenerateCrosswordMessage $message): void
    {
        $type = $message->type();
        $factory = $this->constructorFactory->create($type);
        $crosswordDto = $factory->build($message->language(), $message->wordCount());

        $key = sprintf('%s-%s-%d', $message->language(), (string) $type->getValue(), $message->wordCount());
        $this->cacheItemPool->save(new CacheItem($key, json_encode($crosswordDto, JSON_THROW_ON_ERROR)));
    }
}
