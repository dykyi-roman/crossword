<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Features\SupportedLanguages\Response;

use App\Dictionary\Features\SupportedLanguages\Response\HttpStatusCode;
use App\Dictionary\Features\SupportedLanguages\Response\SuccessApiResponse;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Dictionary\Features\SupportedLanguages\Response\SuccessApiResponse
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
