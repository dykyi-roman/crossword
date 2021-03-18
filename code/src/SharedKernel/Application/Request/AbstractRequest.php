<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Request;

use App\SharedKernel\Application\Assert\RequestAssert;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractRequest
{
    protected RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     */
    public function format(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (string) $request->headers->get('X-FORMAT', 'json');
    }
}
