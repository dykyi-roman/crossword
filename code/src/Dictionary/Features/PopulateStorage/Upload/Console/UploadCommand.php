<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\Upload\Console;

use App\Dictionary\Features\PopulateStorage\Upload\FileAssert;
use App\Dictionary\Features\PopulateStorage\Upload\WordsStorageUpload;
use App\Dictionary\Features\PopulateStorage\Upload\WordsStorageUploadCriteria;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class UploadCommand extends AbstractCommand
{
    protected static $defaultName = 'dictionary:upload';

    private WordsStorageUpload $wordsStorageUpload;

    public function __construct(WordsStorageUpload $wordsStorageUpload)
    {
        parent::__construct();

        $this->wordsStorageUpload = $wordsStorageUpload;
    }

    protected function configure(): void
    {
        $this->setDescription('Upload a new words and his definition to the storage.');
        $this->addArgument('file-path', InputArgument::REQUIRED, 'File path');
        $this->setHelp(
            <<<HELP
The command upload a new words and his definition to the storage 
    <info>php %command.full_name% file.csv</info>
HELP
        );
    }

    protected function doExecute(InputInterface $input): string
    {
        $criteria = new WordsStorageUploadCriteria((string) $input->getArgument('file-path'));
        $count = $this->wordsStorageUpload->execute($criteria);

        return sprintf('Upload %s words.', $count);
    }

    /**
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function validateInput(InputInterface $input): void
    {
        FileAssert::assertCsvFile((string) $input->getArgument('file-path'));
    }
}
