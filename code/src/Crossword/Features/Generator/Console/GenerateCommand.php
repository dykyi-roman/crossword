<?php

declare(strict_types=1);

namespace App\Crossword\Features\Generator\Console;

use App\Crossword\Features\Generator\CrosswordGenerator;
use App\Crossword\Features\Generator\GenerateCriteria;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Webmozart\Assert\Assert;

final class GenerateCommand extends AbstractCommand
{
    private const LIMIT = '100';

    protected static $defaultName = 'crossword:generate';

    private CrosswordGenerator $crosswordGenerator;

    public function __construct(CrosswordGenerator $crosswordGenerator)
    {
        parent::__construct();
        $this->crosswordGenerator = $crosswordGenerator;
    }

    protected function configure(): void
    {
        $this->setDescription('Generate a new crossword.');
        $this->addArgument('type', InputArgument::REQUIRED, 'Type');
        $this->addArgument('language', InputArgument::REQUIRED, 'Language');
        $this->addArgument('word-count', InputArgument::REQUIRED, 'Word count');
        $this->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'limit', self::LIMIT);
        $this->setHelp(
            <<<HELP
The command generate a new crossword 
    <info>php %command.full_name% normal en 2</info>
HELP
        );
    }

    protected function doExecute(InputInterface $input): string
    {
        $this->crosswordGenerator->generate(
            new GenerateCriteria(
                (string) $input->getArgument('type'),
                (string) $input->getArgument('language'),
                (int) $input->getArgument('word-count'),
                (int) $input->getOption('limit')
            )
        );

        return sprintf('Try to generate %d new crosswords.', (int) $input->getOption('limit'));
    }

    /**
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function validateInput(InputInterface $input): void
    {
        Assert::greaterThan((int) $input->getArgument('word-count'), 1);
        if ($input->getOption('limit')) {
            Assert::lessThanEq((int) $input->getOption('limit'), self::LIMIT);
        }
    }
}
