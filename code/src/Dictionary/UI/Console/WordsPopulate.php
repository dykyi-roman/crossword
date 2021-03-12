<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Console;

use App\Dictionary\Application\Assert\FileAssert;
use App\Dictionary\Application\Console\Criteria\WordsPopulateCriteria;
use App\Dictionary\Application\Console\Processor\WordsPopulateProcessor;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

final class WordsPopulate extends AbstractCommand
{
    protected static $defaultName = 'dictionary:words-populate';

    private string $filePath;
    private array $dictionaryList;
    private WordsPopulateProcessor $processor;

    public function __construct(WordsPopulateProcessor $processor, array $dictionaryList)
    {
        parent::__construct();

        $this->processor = $processor;
        $this->dictionaryList = $dictionaryList;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Populate a new words to elastic')
            ->addArgument('language', InputArgument::REQUIRED, 'Language code')
            ->addOption('file-path', null, InputOption::VALUE_OPTIONAL, 'File path')
            ->setHelp(
                <<<HELP
The command populate a new words to elastic 
    <info>php %command.full_name% ua</info>
    <info>php %command.full_name% ua --file-path=file.txt</info>
HELP
            );
    }

    protected function doExecute(InputInterface $input, SymfonyStyle $io): void
    {
        $criteria = new WordsPopulateCriteria($input->getArgument('language'), $this->filePath);
        $this->processor->launchByCriteria($criteria);
    }

    protected function validateInput(InputInterface $input): void
    {
        if ($this->filePath = (string) $input->getOption('file-path')) {
            FileAssert::assertTxtFile($input->getOption('file-path'));

            return;
        }

        if (!array_key_exists($input->getArgument('language'), $this->dictionaryList)) {
            throw new RuntimeException('Dictionary is not found for words populate.');
        }

        $this->filePath = $this->dictionaryList[$input->getArgument('language')];
    }
}
