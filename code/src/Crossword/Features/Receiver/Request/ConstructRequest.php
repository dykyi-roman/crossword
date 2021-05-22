<?php

declare(strict_types=1);

namespace App\Crossword\Features\Receiver\Request;

use App\Crossword\Features\Receiver\Type\Type;
use App\Crossword\Features\Receiver\Type\TypeAssert;
use Symfony\Component\HttpFoundation\RequestStack;
use Webmozart\Assert\Assert;

final class ConstructRequest
{
    private const LIMIT = 100;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function type(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $type = (string) $request->get('type', Type::NORMAL);

        TypeAssert::assertSupportedType($type);

        return $type;
    }

    public function wordCount(): int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $wordCount = (int) $request->get('words', self::LIMIT);

        Assert::lessThanEq($wordCount, self::LIMIT);
        Assert::greaterThan($wordCount, 1);

        return $wordCount;
    }

    public function language(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (string) $request->get('language', 'en');
    }
}
