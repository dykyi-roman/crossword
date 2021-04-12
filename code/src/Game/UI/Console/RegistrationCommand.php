<?php

declare(strict_types=1);

namespace App\Game\UI\Console;

use App\Game\Application\Assert\PasswordAssert;
use App\Game\Application\Assert\RoleAssert;
use App\Game\Application\Criteria\RegistrationCriteria;
use App\Game\Application\Service\Auth\Registration;
use App\SharedKernel\Infrastructure\Responder\ConsoleResponder;
use App\SharedKernel\UI\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

final class RegistrationCommand extends AbstractCommand
{
    protected static $defaultName = 'game:registration';

    private Registration $registration;

    public function __construct(Registration $registration)
    {
        parent::__construct();
        $this->registration = $registration;
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

    protected function doExecute(InputInterface $input, ConsoleResponder $consoleResponder): void
    {
        $this->registration->execute(new RegistrationCriteria(
            (string) $input->getArgument('nickname'),
            (string) $input->getArgument('password'),
            (string) $input->getOption('role'),
        ));

        $consoleResponder('Player successfully created');
    }

    protected function validateInput(InputInterface $input): void
    {
        PasswordAssert::assertValidPassword((string) $input->getArgument('password'));
        if ($input->getOption('role')) {
            RoleAssert::assertSupportedRole((string) $input->getOption('role'));
        }
    }
}
