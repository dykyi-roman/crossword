<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Domain\Dto\WordsCollectionDto;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;
use App\SharedKernel\Domain\Model\Mask;

interface ReadWordsStorageInterface
{
    /**
     * @throws WordNotFoundInStorageException
     */
    public function search(string $language, Mask $mask, int $limit): WordsCollectionDto;

    public function language(): array;
}
