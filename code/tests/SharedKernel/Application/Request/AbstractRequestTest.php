<?php

declare(strict_types=1);

namespace App\Tests\SharedKernel\Application\Request;

use App\SharedKernel\Application\Request\AbstractRequest;
use Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @coversDefaultClass \App\SharedKernel\Application\Request\AbstractRequest
 */
final class AbstractRequestTest extends TestCase
{
    /**
     * @covers ::format
     *
     * @dataProvider formatDataProvider
     */
    public function testRequestWithFormatFieldInHeaders(array $headers, string $result): void
    {
        $request = $this->createRequest($headers);

        self::assertSame($request->format(), $result);
    }

    private function createRequest(array $headers): AbstractRequest
    {
        $request = new Request();
        $request->headers->add($headers);

        $requestStack = new RequestStack();
        $requestStack->push($request);

        return new class($requestStack) extends AbstractRequest {
        };
    }

    public function formatDataProvider(): Generator
    {
        yield 'Request with header that include XML format type' => [['X-FORMAT' => 'xml'], 'xml'];
        yield 'Request with header that include JSON format type' => [['X-FORMAT' => 'json'], 'json'];
        yield 'Request with without headers' => [[], 'json'];
    }
}
