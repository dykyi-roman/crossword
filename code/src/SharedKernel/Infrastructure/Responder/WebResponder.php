<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class WebResponder implements EventSubscriberInterface
{
    private const SUPPORTED_CONTENT_TYPE = null;

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        if (self::SUPPORTED_CONTENT_TYPE !== $request->getContentType()) {
            return;
        }

        $response = $viewEvent->getControllerResult();
        $content = $this->twig->render($response->template(), $response->parameters());

        $viewEvent->setResponse((new Response())->setContent($content));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke'],
        ];
    }
}
