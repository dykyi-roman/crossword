<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Receiver;

use App\Crossword\Features\Receiver\CrosswordReceiver;
use App\Crossword\Features\Receiver\ReceiveCrosswordException;
use App\Crossword\Features\Receiver\Type\Type;
use App\Crossword\Infrastructure\Cache\CacheItem;
use App\Crossword\Infrastructure\Cache\InMemoryClient;
use App\Crossword\Infrastructure\Repository\Redis\ReadCrosswordRepository;
use Psr\Log\NullLogger;
use App\Tests\Crossword\CrosswordTestCase;

/**
 * @coversDefaultClass \App\Crossword\Features\Receiver\CrosswordReceiver
 */
final class CrosswordReceiverTest extends CrosswordTestCase
{
    /**
     * @covers ::receive
     */
    public function testSuccessfullyReceived(): void
    {
        $data = ['data' => 'value'];
        $cache = new InMemoryClient();
        $cache->save(new CacheItem('ua-normal-3', [time() => json_encode(['data' => 'value'], JSON_THROW_ON_ERROR)]));

        $crosswordReceiver = new CrosswordReceiver(new ReadCrosswordRepository($cache), new NullLogger());
        $crossword = $crosswordReceiver->receive(sprintf('%s-%s-%d', 'ua', Type::NORMAL, 3));

        self::assertSame($crossword, $data);
    }

    /**
     * @covers ::receive
     */
    public function testThrowExceptionWhenCrosswordNotFoundInTheStorage(): void
    {
        $this->expectException(ReceiveCrosswordException::class);

        $crosswordReceiver = new CrosswordReceiver(new ReadCrosswordRepository(new InMemoryClient()), new NullLogger());
        $crosswordReceiver->receive(sprintf('%s-%s-%d', 'ua', Type::NORMAL, 3));
    }
}
