<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Application\Response;

use App\Dictionary\Application\Enum\HttpStatusCode;
use App\Dictionary\Application\Response\API\SuccessApiResponse;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Dictionary\Application\Response\API\SuccessApiResponse
 */
final class SuccessResponseTest extends TestCase
{
    /**
     * @covers ::status
     */
    public function testSuccessResponseStatus(): void
    {
        $response = new SuccessApiResponse();

        self::assertSame($response->status(), HttpStatusCode::HTTP_OK);
    }

    /**
     * @covers ::body
     */
    public function testSuccessResponseBody(): void
    {
        $data = ['test' => Factory::create()->word];

        $response = new SuccessApiResponse($data);

        self::assertSame($response->body()['data'], $data);
    }
}
