<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use SimpleXMLElement;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class XmlResponder implements EventSubscriberInterface
{
    private const SUPPORTED_CONTENT_TYPE = 'xml';

    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        if (self::SUPPORTED_CONTENT_TYPE !== $request->getContentType()) {
            return;
        }

        $response = $viewEvent->getControllerResult();
        $data = $response->body();
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($data, [$xml, 'addChild']);

        $viewEvent->setResponse(new Response((string) $xml->asXML(), $response->status(), [
            'Content-Type' => 'text/xml',
        ]));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke'],
        ];
    }
}
