<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\FailedSaveToStorageException;

interface WriteWordsStorageInterface
{
    /**
     * @throws FailedSaveToStorageException
     */
    public function save(Word $word): void;
}
