<?php

declare(strict_types=1);

namespace App\Tests\Game\Features\Answers\Response;

use App\Game\Features\Answers\Response\HttpStatusCode;
use App\Game\Features\Answers\Response\SuccessApiResponse;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Game\Features\Answers\Response\SuccessApiResponse
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
