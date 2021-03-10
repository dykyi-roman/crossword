<?php

declare(strict_types=1);

namespace App\Dictionary\Application\Request;

use App\Dictionary\Application\Assert\RequestAssert;
use Symfony\Component\HttpFoundation\RequestStack;

final class WordRequest
{
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function length(): ?int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (int) $request->query->get('length');
    }

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
}
