<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Application\Service;

use App\Crossword\Application\Exception\ReceiveCrosswordException;
use App\Crossword\Application\Service\CrosswordReceiver;
use App\Crossword\Domain\Enum\Type;
use App\Crossword\Infrastructure\Cache\CacheItem;
use App\Crossword\Infrastructure\Cache\InMemoryClient;
use App\Tests\CrosswordTestCase;
use Psr\Log\NullLogger;

/**
 * @coversDefaultClass \App\Crossword\Application\Service\CrosswordReceiver
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

        $crosswordReceiver = new CrosswordReceiver($cache, new NullLogger());
        $crossword = $crosswordReceiver->receive(Type::normal(), 'ua', 3);

        self::assertSame($crossword, $data);
    }

    /**
     * @covers ::receive
     */
    public function testThrowExceptionWhenCrosswordNotFoundInTheStorage(): void
    {
        $this->expectException(ReceiveCrosswordException::class);

        $crosswordReceiver = new CrosswordReceiver(new InMemoryClient(), new NullLogger());
        $crosswordReceiver->receive(Type::normal(), 'ua', 3);
    }
}
