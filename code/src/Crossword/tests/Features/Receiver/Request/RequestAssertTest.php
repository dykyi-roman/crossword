<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Features\Receiver\Request;

use App\Crossword\Features\Receiver\Request\RequestAssert;
use App\Crossword\Features\Receiver\Request\RequestException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \App\Crossword\Features\Receiver\Request\RequestAssert
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
