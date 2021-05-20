<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Storage;

use App\Dictionary\Features\WordsFinder\Mask\Mask;
use App\Dictionary\Features\WordsFinder\Word\WordDtoCollection;

interface ReadWordsStorageInterface
{
    /**
     * @throws WordNotFoundInStorageException
     */
    public function search(string $language, Mask $mask, int $limit): WordDtoCollection;
}
