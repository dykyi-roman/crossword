<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic\Exception;

use DomainException;

final class FailedSaveToStorageException extends DomainException
{
    public function __construct(string $word, string $language)
    {
        $message = sprintf('The word "%s" is not write in the "%s" dictionary', $word, $language);

        parent::__construct($message);
    }
}
