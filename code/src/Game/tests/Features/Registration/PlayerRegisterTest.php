<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Registration;

use App\Game\Features\Registration\PlayerRegister;
use App\Game\Features\Registration\PlayerRegisterCriteria;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\Registration\PlayerRegister
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
