<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Request;

use App\SharedKernel\Application\Assert\RequestAssert;
use App\SharedKernel\Application\Request\AbstractRequest;

final class WordRequest extends AbstractRequest
{
    private const LIMIT = '50';

    public function mask(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $query = $request->query;

        return (string) $query->get('mask', '');
    }

    public function language(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (string) $request->get('language', 'en');
    }

    public function limit(): int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $headers = $request->headers;

        return (int) $headers->get('X-LIMIT', self::LIMIT);
    }
}
