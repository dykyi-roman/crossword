<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway\Exception;

use DomainException;
use Throwable;

final class DefinitionNotFoundInApiGateway extends DomainException
{
    public function __construct(string $word, string $language, int $code = 0, Throwable $throwable = null)
    {
        $message = sprintf('The word "%s" is not found on the "%s" language', $word, $language);

        parent::__construct($message, $code, $throwable);
    }
}