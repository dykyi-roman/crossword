<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Repository;

use App\Dictionary\Domain\Model\WordCollection;
use App\Dictionary\Infrastructure\Repository\Elastic\Exception\WordNotFoundInStorageException;

interface ReadWordsStorageInterface
{
    /**
     * @throws WordNotFoundInStorageException
     */
    public function search(string $language, string $mask, int $limit): WordCollection;

    public function language(): array;
}
