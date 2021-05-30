<?php

declare(strict_types=1);

namespace App\Game\Features\Registration\Console;

use App\Game\Features\Registration\PasswordAssert;
use App\Game\Features\Registration\PlayerRegister;
use App\Game\Features\Registration\PlayerRegisterCriteria;
use App\Game\Features\Registration\Role\RoleAssert;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

final class CreatePlayerCommand extends AbstractCommand
{
    protected static $defaultName = 'game:create-player';

    private PlayerRegister $playerRegister;

    public function __construct(PlayerRegister $playerRegister)
    {
        parent::__construct();
        $this->playerRegister = $playerRegister;
    }

    protected function configure(): void
    {
        $this->setDescription('Registration a new player.');
        $this->addArgument('nickname', InputArgument::REQUIRED, 'Nickname');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');
        $this->addOption('role', null, InputOption::VALUE_OPTIONAL, 'role');
        $this->setHelp(
            <<<HELP
The command register a new player 
    <info>php %command.full_name% user password</info>
    <info>php %command.full_name% user password --role=</info>
HELP
        );
    }

    protected function doExecute(InputInterface $input): string
    {
        $this->playerRegister->execute(new PlayerRegisterCriteria(
            (string) $input->getArgument('nickname'),
            (string) $input->getArgument('password'),
            $input->getOption('role'),
        ));

        return 'Player successfully created.';
    }

    protected function validateInput(InputInterface $input): void
    {
        PasswordAssert::assertValidPassword((string) $input->getArgument('password'));

        if ($input->getOption('role')) {
            RoleAssert::assertSupportedRole((string) $input->getOption('role'));
        }
    }
}
