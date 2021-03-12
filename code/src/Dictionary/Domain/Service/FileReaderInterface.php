<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use Generator;

interface FileReaderInterface
{
    public function open(string $filePath): void;

    public function rows(): ?Generator;
}
