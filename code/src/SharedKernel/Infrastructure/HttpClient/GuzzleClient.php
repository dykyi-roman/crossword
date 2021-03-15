<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient;

use GuzzleHttp\HandlerStack;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

final class GuzzleClient implements ClientInterface
{
    private Client $client;
    private array $middleware;

    public function __construct(Client $client, array $middleware = [])
    {
        $this->client = $client;
        $this->middleware = $middleware;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request, $this->defaultOptions($request->getHeaders()));
    }

    private function defaultOptions(array $headers): array
    {
        $stack = HandlerStack::create();
        foreach ($this->middleware as $middleware) {
            $stack->push($middleware);
        }

        return [
            'verify' => false,
            'http_errors' => false,
            'handler' => $stack,
            'headers' => array_merge(['Content-Type' => 'application/json'], $headers),
        ];
    }
}
