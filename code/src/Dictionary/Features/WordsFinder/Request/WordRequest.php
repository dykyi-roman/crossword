<?php

declare(strict_types=1);

namespace App\Dictionary\Features\WordsFinder\Request;

use Symfony\Component\HttpFoundation\RequestStack;

final class WordRequest
{
    private const LIMIT = 100;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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

        return (int) $headers->get('X-LIMIT', (string) self::LIMIT);
    }
}
