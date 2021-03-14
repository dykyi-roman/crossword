<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Exception;

use DomainException;
use Throwable;

final class FailedWriteToStorageException extends DomainException
{
    public function __construct(string $word, string $language, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The word "%s" is not write in the "%s" dictionary', $word, $language);

        parent::__construct($message, $code, $previous);
    }
}
