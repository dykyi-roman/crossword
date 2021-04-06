<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ConsoleResponder
{
    private SymfonyStyle $symfonyStyle;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->symfonyStyle = new SymfonyStyle($input, $output);
    }

    public function __invoke(string $message): void
    {
        $this->symfonyStyle->info($message);
    }
}
