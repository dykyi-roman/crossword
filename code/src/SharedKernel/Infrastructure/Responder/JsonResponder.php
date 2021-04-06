<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class JsonResponder implements EventSubscriberInterface
{
    private const SUPPORTED_CONTENT_TYPE = 'json';

    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        if (self::SUPPORTED_CONTENT_TYPE !== $request->getContentType()) {
            return;
        }

        $response = $viewEvent->getControllerResult();
        $viewEvent->setResponse(new JsonResponse($response->body(), $response->status()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke'],
        ];
    }
}
