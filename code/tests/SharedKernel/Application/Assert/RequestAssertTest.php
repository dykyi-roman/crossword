<?php

declare(strict_types=1);

namespace App\Tests\SharedKernel\Application\Assert;

use App\Dictionary\Application\Exception\RequestException;
use App\SharedKernel\Application\Assert\RequestAssert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \App\SharedKernel\Application\Assert\RequestAssert
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
