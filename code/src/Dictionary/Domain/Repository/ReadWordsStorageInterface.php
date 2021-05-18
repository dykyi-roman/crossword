<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Domain\Dto\WordDtoCollection;
use App\Dictionary\Domain\Exception\WordNotFoundInStorageException;
use App\Dictionary\Domain\Model\Mask;

interface ReadWordsStorageInterface
{
    /**
     * @throws WordNotFoundInStorageException
     */
    public function search(string $language, Mask $mask, int $limit): WordDtoCollection;

    public function language(): array;
}
