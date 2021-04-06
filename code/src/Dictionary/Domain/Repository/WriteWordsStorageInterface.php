<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Infrastructure\Repository\Elastic\Exception\FailedSaveToStorageException;
use App\SharedKernel\Domain\Model\Word;

interface WriteWordsStorageInterface
{
    /**
     * @throws FailedSaveToStorageException
     */
    public function save(string $language, Word $word): void;
}
