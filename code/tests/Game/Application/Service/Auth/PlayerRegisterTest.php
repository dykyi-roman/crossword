<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Service\Auth;

use App\Game\Application\Criteria\PlayerRegisterCriteria;
use App\Game\Application\Service\Auth\PlayerRegister;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Application\Service\Auth\PlayerRegister
 */
final class PlayerRegisterTest extends TestCase
{
    /**
     * @covers ::execute
     */
    public function testSuccessfullyPlayerRegistration(): void
    {
        $repository = new InMemoryPlayerRepository();
        $playerRegister = new PlayerRegister($repository);
        $playerRegister->execute(new PlayerRegisterCriteria('test', '1q2w3e4r', null));

        self::assertCount(1, $repository->players());
    }
}
