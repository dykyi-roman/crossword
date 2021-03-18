<?php

declare(strict_types=1);

namespace App\Tests\SharedKernel\Application\Response;

use App\Dictionary\Application\Enum\ErrorCode;
use App\SharedKernel\Application\Enum\HttpStatusCode;
use App\SharedKernel\Application\Response\FailedResponse;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\SharedKernel\Application\Response\FailedResponse
 */
final class FailedResponseTest extends TestCase
{
    /**
     * @covers ::status
     *
     * @dataProvider errorCodeDataProvider
     */
    public function testFailedResponseStatus(ErrorCode $errorCode): void
    {
        $response = new FailedResponse($errorCode);

        self::assertSame($response->status(), HttpStatusCode::HTTP_ERROR);
    }

    /**
     * @covers ::body
     *
     * @dataProvider errorCodeDataProvider
     */
    public function testFailedResponseBody(ErrorCode $errorCode): void
    {
        $response = new FailedResponse($errorCode);

        self::assertSame($response->body()['error']['code'], $errorCode->getKey());
        self::assertSame($response->body()['error']['message'], $errorCode->getValue());
    }

    public function errorCodeDataProvider(): Generator
    {
        yield 'Dictionary is empty error' => [new ErrorCode(ErrorCode::DICTIONARY_IS_EMPTY)];
        yield 'Word is not found error' => [new ErrorCode(ErrorCode::WORD_IS_NOT_FOUND)];
    }
}
