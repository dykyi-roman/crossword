<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Exception;

use RuntimeException;

final class WordException extends RuntimeException
{
    public static function wordIsNotFound(string $mask, string $language): self
    {
        return new self(sprintf('The word is ot found by mask "%s" in the "%s" dictionary', $mask, $language));
    }

    public static function failedToAddNewWord(string $word, string $language): self
    {
        return new self(sprintf('The word "%s" is not write in the "%s" dictionary', $word, $language));
    }
}
