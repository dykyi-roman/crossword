<?php

declare(strict_types=1);

namespace App\Shared\Application\Response;

use SimpleXMLElement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseFactory
{
    private string $format;

    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function success(array $payload): Response
    {
        return $this->create(new SuccessResponse($payload));
    }

    public function failed(string $message): Response
    {
        return $this->create(new FailedResponse($message));
    }

    private function create(ResponseInterface $response): Response
    {
        switch ($this->format) {
            case 'xml':
                $data = $response->body();
                $xml = new SimpleXMLElement('<root/>');
                array_walk_recursive($data, [$xml, 'addChild']);

                return new XmlResponse($xml->asXML(), $response->status());
            default:
                return new JsonResponse($response->body(), $response->status());
        }
    }
}
