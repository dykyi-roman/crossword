<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\WordsFinder\Request;

use App\Dictionary\Features\WordsFinder\Request\RequestAssert;
use App\Dictionary\Features\WordsFinder\Request\RequestException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \App\Dictionary\Features\WordsFinder\Request\RequestAssert
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
