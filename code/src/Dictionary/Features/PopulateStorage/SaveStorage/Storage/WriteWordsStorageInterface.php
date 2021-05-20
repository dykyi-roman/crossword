<?php

declare(strict_types=1);

namespace App\Dictionary\Features\PopulateStorage\SaveStorage\Storage;

use App\Dictionary\Features\PopulateStorage\SaveStorage\Word;

interface WriteWordsStorageInterface
{
    /**
     * @throws FailedSaveToStorageException
     */
    public function save(string $language, Word $word): void;
}
