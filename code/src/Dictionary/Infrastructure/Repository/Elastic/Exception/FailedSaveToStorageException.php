<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic\Exception;

use DomainException;
use Throwable;

final class FailedSaveToStorageException extends DomainException
{
    public function __construct(string $word, string $language, int $code = 0, Throwable $throwable = null)
    {
        $message = sprintf('The word "%s" is not write in the "%s" dictionary', $word, $language);

        parent::__construct($message, $code, $throwable);
    }
}
