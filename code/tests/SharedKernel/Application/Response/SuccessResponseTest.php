<?php

declare(strict_types=1);

namespace App\Tests\SharedKernel\Application\Response;

use App\SharedKernel\Application\Enum\HttpStatusCode;
use App\SharedKernel\Application\Response\SuccessResponse;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\SharedKernel\Application\Response\SuccessResponse
 */
final class SuccessResponseTest extends TestCase
{
    /**
     * @covers ::status
     */
    public function testSuccessResponseStatus(): void
    {
        $response = new SuccessResponse();

        self::assertSame($response->status(), HttpStatusCode::HTTP_OK);
    }

    /**
     * @covers ::body
     */
    public function testSuccessResponseBody(): void
    {
        $data = ['test' => Factory::create()->word];

        $response = new SuccessResponse($data);

        self::assertSame($response->body()['data'], $data);
    }
}
