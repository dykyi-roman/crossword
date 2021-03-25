<?php

declare(strict_types=1);

namespace App\Crossword\Application\Request;

use App\Crossword\Application\Assert\TypeAssert;
use App\Crossword\Domain\Enum\Type;
use App\SharedKernel\Application\Assert\RequestAssert;
use App\SharedKernel\Application\Request\AbstractRequest;
use Webmozart\Assert\Assert;

final class ConstructRequest extends AbstractRequest
{
    private const LIMIT = 100;

    public function type(): Type
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $type = (string) $request->get('type', Type::NORMAL);

        TypeAssert::assertSupportedType($type);

        return new Type($type);
    }

    public function wordCount(): int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $wordCount = (int) $request->get('words', self::LIMIT);

        Assert::lessThanEq($wordCount, self::LIMIT);

        return $wordCount;
    }

    public function language(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (string) $request->get('language', 'en');
    }
}
