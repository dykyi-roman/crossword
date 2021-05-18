<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Domain\Exception\FailedSaveToStorageException;
use App\Dictionary\Domain\Model\Word;

interface WriteWordsStorageInterface
{
    /**
     * @throws FailedSaveToStorageException
     */
    public function save(string $language, Word $word): void;
}
