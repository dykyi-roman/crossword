<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Service;

use App\Dictionary\Domain\Exception\WordException;
use App\Dictionary\Domain\Model\Word;
use App\Dictionary\Domain\Model\WordCollection;

interface WordsStorageInterface
{
    public function write(Word $word): void;

    /**
     * @throws WordException
     */
    public function find(string $language, string $mask, ?int $length = null): WordCollection;
}