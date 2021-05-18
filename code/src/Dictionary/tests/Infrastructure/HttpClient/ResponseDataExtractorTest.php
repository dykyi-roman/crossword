<?php

declare(strict_types=1);

namespace App\Tests\Dictionary\Infrastructure\HttpClient;

use App\Dictionary\Infrastructure\HttpClient\ResponseDataExtractor;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Dictionary\Infrastructure\HttpClient\ResponseDataExtractor
 */
final class ResponseDataExtractorTest extends TestCase
{
    /**
     * @covers ::extract
     */
    public function testSuccessfullyExtractDataFromResponse(): void
    {
        $body = ['data' => 'test'];

        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($body));
        $responseDataExtractor = new ResponseDataExtractor();

        self::assertSame($responseDataExtractor->extract($response), $body);
    }
}
