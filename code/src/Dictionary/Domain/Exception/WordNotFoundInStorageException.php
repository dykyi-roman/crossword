<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Exception;

use DomainException;

final class WordNotFoundInStorageException extends DomainException
{
    public function __construct(string $mask, string $language)
    {
        $message = sprintf('The word is not found by mask "%s" in the "%s" dictionary', $mask, $language);

        parent::__construct($message);
    }
}
