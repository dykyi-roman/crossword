<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\History;

use App\Game\Features\History\History;
use App\Game\Features\History\HistoryId;
use App\Game\Features\History\PlayerHistory;
use App\Game\Infrastructure\Dao\InMemory\InMemoryHistoryDao;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\History\PlayerHistory
 */
final class PlayerHistoryTest extends TestCase
{
    /**
     * @covers ::__invoke
     */
    public function testReceivedPlayersHistory(): void
    {
        $history = new History(new HistoryId());
        $history->changeLevel(2);

        $history2 = new History(new HistoryId());
        $history2->changeLevel(1);

        $repository = new InMemoryHistoryDao($history, $history2);
        $playerHistory = new PlayerHistory($repository);

        $result = $playerHistory->__invoke();

        self::assertCount(2, $result);
    }
}
