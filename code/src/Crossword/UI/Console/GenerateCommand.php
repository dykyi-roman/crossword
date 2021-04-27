<?php

declare(strict_types=1);

namespace App\Crossword\UI\Console;

use App\Crossword\Application\Assert\TypeAssert;
use App\Crossword\Application\Criteria\GenerateCriteria;
use App\Crossword\Application\Service\CrosswordGenerator;
use App\SharedKernel\Application\Response\Console\ResponseInterface;
use App\SharedKernel\UI\Console\AbstractCommand;
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
        $this->addArgument('word-count', InputArgument::REQUIRED, 'Word count');
        $this->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'limit', self::LIMIT);
        $this->setHelp(
            <<<HELP
The command generate a new crossword 
    <info>php %command.full_name% normal 2</info>
HELP
        );
    }

    protected function doExecute(InputInterface $input, ResponseInterface $response): void
    {
        $this->crosswordGenerator->generate(
            new GenerateCriteria(
                (string) $input->getArgument('type'),
                (int) $input->getArgument('word-count'),
                (int) $input->getOption('limit')
            )
        );

        $response(sprintf('Try to generate %d new crosswords.', (int) $input->getOption('limit')));
    }

    /**
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function validateInput(InputInterface $input): void
    {
        TypeAssert::assertSupportedType((string) $input->getArgument('type'));
        Assert::greaterThan((int) $input->getArgument('word-count'), 1);
        if ($input->getOption('limit')) {
            Assert::lessThanEq((int) $input->getOption('limit'), self::LIMIT);
        }
    }
}
