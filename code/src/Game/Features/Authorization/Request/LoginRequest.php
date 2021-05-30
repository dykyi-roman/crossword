<?php

declare(strict_types=1);

namespace App\Game\Features\Authorization\Request;

use Symfony\Component\HttpFoundation\RequestStack;

final class LoginRequest
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function nickname(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $post = $request->request;

        return (string) $post->get('nickname');
    }

    public function password(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $post = $request->request;

        return (string) $post->get('password');
    }
}
