<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use App\Dictionary\Domain\Exception\FileOpenException;
use Generator;

interface FileReaderInterface
{
    /**
     * @throws FileOpenException
     */
    public function read(string $filePath): Generator;
}
