<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Request;

use App\SharedKernel\Application\Assert\RequestAssert;
use App\SharedKernel\Application\Request\AbstractRequest;

final class WordRequest extends AbstractRequest
{
    private const LENGTH = '10';

    public function mask(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return $request->query->get('mask', '');
    }

    public function language(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return $request->get('language');
    }

    public function length(): int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (int) $request->headers->get('X-LENGTH', self::LENGTH);
    }
}
