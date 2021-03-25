<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Gateway\Exception;

use DomainException;

final class DefinitionNotFoundInApiGateway extends DomainException
{
    public function __construct(string $word, string $language)
    {
        $message = sprintf('The word "%s" is not found on the "%s" language', $word, $language);

        parent::__construct($message);
    }
}
