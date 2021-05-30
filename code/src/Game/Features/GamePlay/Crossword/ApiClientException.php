<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

use DomainException;

final class ApiClientException extends DomainException
{
    public static function badRequest(string $message): self
    {
        return new self(sprintf('Bad request. Reason: %s', $message));
    }
}
