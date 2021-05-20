<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\FileReader;

use Generator;

interface FileReaderInterface
{
    /**
     * @throws OpenFileException
     */
    public function read(string $filePath): Generator;
}
