<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Console;

use App\Dictionary\Application\Assert\FileAssert;
use App\Dictionary\Application\Criteria\WordsStorageUploadCriteria;
use App\Dictionary\Application\Service\WordsStorageUpload;
use App\SharedKernel\UI\Console\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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

    protected function doExecute(InputInterface $input, SymfonyStyle $symfonyStyle): void
    {
        $criteria = new WordsStorageUploadCriteria((string) $input->getArgument('file-path'));
        $count = $this->wordsStorageUpload->execute($criteria);

        $symfonyStyle->info(sprintf('Upload %s words.', $count));
    }

    /**
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function validateInput(InputInterface $input): void
    {
        FileAssert::assertCsvFile((string) $input->getArgument('file-path'));
    }
}
