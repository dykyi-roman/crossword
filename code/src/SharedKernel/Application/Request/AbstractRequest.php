<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Request;

use App\SharedKernel\Application\Assert\RequestAssert;
use App\SharedKernel\Application\Enum\ResponseFormat;
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

        $headers = $request->headers;

        return (string) $headers->get('X-FORMAT', ResponseFormat::JSON);
    }
}
