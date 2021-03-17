<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use App\Dictionary\Domain\Exception\FailedWriteToStorageException;
use App\Dictionary\Domain\Exception\WordNotFoundInStorageException;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Model\WordCollection;

interface WordsStorageInterface
{
    /**
     * @throws FailedWriteToStorageException
     */
    public function add(Word $word): void;

    /**
     * @throws WordNotFoundInStorageException
     */
    public function search(string $language, string $mask, int $limit): WordCollection;

    public function language(): array;
}