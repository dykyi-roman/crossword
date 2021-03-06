<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

abstract class AbstractCommand extends Command
{
    abstract protected function doExecute(InputInterface $input): string;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->validateInput($input);
        $symfonyStyle = new SymfonyStyle($input, $output);
        try {
            $memory = memory_get_usage();
            $start = microtime(true);
            $symfonyStyle->info($this->doExecute($input));
            $stop = number_format(microtime(true) - $start, 2);

            $symfonyStyle->success(
                sprintf('Process took %f seconds. Memory used %f bytes.', $stop, memory_get_usage() - $memory)
            );

            return Command::SUCCESS;
        } catch (Throwable $exception) {
            $symfonyStyle->error($exception->getMessage());

            return Command::FAILURE;
        }
    }

    protected function validateInput(InputInterface $input): void
    {
    }
}
