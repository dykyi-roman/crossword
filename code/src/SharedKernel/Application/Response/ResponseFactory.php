<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response;

use App\Dictionary\Application\Enum\ErrorCode;
use App\SharedKernel\Application\Enum\ResponseFormat;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseFactory
{
    public function success(array $payload, string $format): Response
    {
        return $this->create(new SuccessResponse($payload), $format);
    }

    public function failed(ErrorCode $errorCode, string $format): Response
    {
        return $this->create(new FailedResponse($errorCode), $format);
    }

    private function create(ResponseInterface $response, string $format): Response
    {
        switch ($format) {
            case ResponseFormat::XML:
                $data = $response->body();
                $xml = new SimpleXMLElement('<root/>');
                array_walk_recursive($data, [$xml, 'addChild']);

                return new XmlResponse((string) $xml->asXML(), $response->status());
            default:
                return new JsonResponse($response->body(), $response->status());
        }
    }
}
