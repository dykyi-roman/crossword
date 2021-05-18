<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class WebResponder implements EventSubscriberInterface
{
    private const SUPPORTED_CONTENT_TYPE = [null, 'form'];

    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        if (!in_array($request->getContentType(), self::SUPPORTED_CONTENT_TYPE, true)) {
            return;
        }

        $viewEvent->setResponse((new Response())->setContent($viewEvent->getControllerResult()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke'],
        ];
    }
}
