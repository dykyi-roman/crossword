<?php

declare(strict_types=1);

namespace App\Game\Application\Request;

use App\Game\Application\Assert\RequestAssert;
use Symfony\Component\HttpFoundation\RequestStack;

final class AnswersRequest
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function answers(): array
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (array) json_decode($request->getContent(), true);
    }
}
