<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Exception;

use DomainException;

final class DefinitionNotFoundInApiGateway extends DomainException
{
    public function __construct(string $word, string $language)
    {
        $message = sprintf('The word "%s" is not found on the "%s" dictionary.', $word, $language);

        parent::__construct($message);
    }
}
