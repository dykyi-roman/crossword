<?php

declare(strict_types=1);

namespace App\Tests\Game\UI\Console;

use App\Game\Application\Service\Auth\PlayerRegister;
use App\Game\Domain\Enum\Role;
use App\Game\Domain\Model\Player;
use App\Game\Infrastructure\Repository\InMemory\InMemoryPlayerRepository;
use App\Game\UI\Console\CreatePlayerCommand;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * @coversDefaultClass \App\Game\UI\Console\CreatePlayerCommand
 */
final class CreatePlayerCommandTest extends TestCase
{
    /**
     * @covers ::execute
     *
     * @dataProvider useRoleDataProvider
     */
    public function testCreatePlayerWithRole(array $roleOption, Role $role): void
    {
        $data = array_merge(['nickname' => 'test', 'password' => '1q2w3e4r'], $roleOption);
        $inMemoryPlayerRepository = new InMemoryPlayerRepository();
        $command = new CreatePlayerCommand(new PlayerRegister($inMemoryPlayerRepository));
        $command->run(new ArrayInput($data), new NullOutput());

        self::assertCount(1, $inMemoryPlayerRepository->players());

        $players = $inMemoryPlayerRepository->players();
        $player = array_shift($players);
        self::assertInstanceOf(Player::class, $player);
        self::assertTrue($player->role()->equals($role));
    }

    public function useRoleDataProvider(): Generator
    {
        yield 'Simple player by default role' => [[], new Role(Role::SIMPLE_PLAYER)];
        yield 'Simple player' => [['--role' => Role::SIMPLE_PLAYER], new Role(Role::SIMPLE_PLAYER)];
        yield 'Premium player' => [['--role' => Role::PREMIUM_PLAYER], new Role(Role::PREMIUM_PLAYER)];
    }
}
