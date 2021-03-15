<?php

declare(strict_types=1);

namespace App\SharedKernel\UI\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

abstract class AbstractCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->validateInput($input);
        $io = new SymfonyStyle($input, $output);
        try {
            $memory = memory_get_usage();
            $start = microtime(true);
            $this->doExecute($input, $io);
            $stop = number_format(microtime(true) - $start, 2);

            $io->success(sprintf('Process took %f seconds. Memory used %f bytes', $stop, memory_get_usage() - $memory));

            return Command::SUCCESS;
        } catch (Throwable $exception) {
            return Command::FAILURE;
        }
    }

    abstract protected function doExecute(InputInterface $input, SymfonyStyle $io): void;

    protected function validateInput(InputInterface $input): void
    {
    }
}
