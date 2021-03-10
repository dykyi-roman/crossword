<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Assert;

use App\Dictionary\Application\Exception\RequestException;
use Symfony\Component\HttpFoundation\Request;

final class RequestAssert
{
    public static function missingRequest(?Request $request): void
    {
        if (null === $request) {
            throw RequestException::missingRequest();
        }
    }
}
