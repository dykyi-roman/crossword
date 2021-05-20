<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Populate\Console;

use App\Dictionary\Features\PopulateStorage\Populate\FileAssert;
use App\Dictionary\Features\PopulateStorage\Populate\WordsStoragePopulate;
use App\Dictionary\Features\PopulateStorage\Populate\WordsStoragePopulateCriteria;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

final class PopulateCommand extends AbstractCommand
{
    protected static $defaultName = 'dictionary:populate';

    private string $filePath;
    private array $dictionaryList;
    private WordsStoragePopulate $wordsStoragePopulate;

    public function __construct(WordsStoragePopulate $wordsStoragePopulate, array $dictionaryList)
    {
        parent::__construct();

        $this->filePath = '';
        $this->wordsStoragePopulate = $wordsStoragePopulate;
        $this->dictionaryList = $dictionaryList;
    }

    protected function configure(): void
    {
        $this->setDescription('Populate a new words to the storage.');
        $this->addArgument('language', InputArgument::REQUIRED, 'Language code');
        $this->addOption('file-path', null, InputOption::VALUE_OPTIONAL, 'File path');
        $this->setHelp(
            <<<HELP
The command populate a new words to the storage 
    <info>php %command.full_name% ua</info>
    <info>php %command.full_name% ua --file-path=file.txt</info>
HELP
        );
    }

    protected function doExecute(InputInterface $input): string
    {
        $criteria = new WordsStoragePopulateCriteria((string) $input->getArgument('language'), $this->filePath);
        $count = $this->wordsStoragePopulate->execute($criteria);

        return sprintf('Populate %s words.', $count);
    }

    /**
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function validateInput(InputInterface $input): void
    {
        if ($this->filePath = (string) $input->getOption('file-path')) {
            FileAssert::assertTxtFile((string) $input->getOption('file-path'));

            return;
        }

        if (!array_key_exists((string) $input->getArgument('language'), $this->dictionaryList)) {
            throw new RuntimeException('Dictionary is not found for words populate.');
        }

        $this->filePath = $this->dictionaryList[(string) $input->getArgument('language')];
    }
}
