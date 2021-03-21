<?php

declare(strict_types=1);

namespace App\Crossword\Application\Request;

use App\Crossword\Application\Assert\LevelAssert;
use App\Crossword\Application\Assert\TypeAssert;
use App\Crossword\Application\Enum\Level;
use App\Crossword\Application\Enum\Type;
use App\SharedKernel\Application\Assert\RequestAssert;
use App\SharedKernel\Application\Request\AbstractRequest;

final class BuildRequest extends AbstractRequest
{
    public function type(): Type
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $type = (string) $request->get('type', Type::SIMPLE);

        TypeAssert::assertSupportedType($type);

        return new Type($type);
    }

    public function level(): int
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        $level = (int) $request->get('level', Level::LEVEL_1);

        LevelAssert::assertSupportedLevel($level);

        return $level;
    }

    public function language(): string
    {
        RequestAssert::missingRequest($request = $this->requestStack->getCurrentRequest());

        return (string) $request->get('language', 'en');
    }
}
