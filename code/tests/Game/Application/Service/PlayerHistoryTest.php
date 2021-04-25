<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Service;

use App\Game\Application\Service\PlayerHistory;
use App\Game\Domain\Enum\Level;
use App\Game\Domain\Model\History;
use App\Game\Domain\Model\HistoryId;
use App\Game\Infrastructure\Dao\InMemory\InMemoryHistoryDao;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Application\Service\PlayerHistory
 */
final class PlayerHistoryTest extends TestCase
{
    /**
     * @covers ::__invoke
     */
    public function testReceivedPlayersHistory(): void
    {
        $history = new History(new HistoryId());
        $history->changeLevel(new Level(Level::LEVEL_2));

        $history2 = new History(new HistoryId());
        $history2->changeLevel(new Level(Level::LEVEL_1));

        $repository = new InMemoryHistoryDao($history, $history2);
        $playerHistory = new PlayerHistory($repository);

        $result = $playerHistory->__invoke();

        self::assertCount(2, $result);
    }
}
