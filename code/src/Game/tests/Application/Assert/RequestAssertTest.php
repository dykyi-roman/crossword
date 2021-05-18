<?php

declare(strict_types=1);

namespace App\Tests\Game\Application\Assert;

use App\Game\Application\Assert\RequestAssert;
use App\Game\Application\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \App\Game\Application\Assert\RequestAssert
 */
final class RequestAssertTest extends TestCase
{
    /**
     * @covers ::missingRequest
     */
    public function testThrowExceptionWhenRequestIsMissing(): void
    {
        $this->expectException(RequestException::class);

        RequestAssert::missingRequest(null);
    }

    /**
     * @covers ::missingRequest
     */
    public function testSuccessfullyRequest(): void
    {
        RequestAssert::missingRequest(new Request());

        self::assertTrue(true);
    }
}
