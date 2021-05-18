<?php

declare(strict_types=1);

namespace App\Tests\Crossword\Application\Assert;

use App\Crossword\Application\Assert\RequestAssert;
use App\Crossword\Application\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \App\Crossword\Application\Assert\RequestAssert
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
