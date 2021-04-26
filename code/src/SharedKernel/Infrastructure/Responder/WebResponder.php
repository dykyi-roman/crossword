<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Responder;

use App\SharedKernel\Application\Response\Web\HtmlResponse;
use App\SharedKernel\Application\Response\Web\TwigResponse;
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
     * @throws \Twig\Error\SyntaxError | \Twig\Error\RuntimeError | \Twig\Error\LoaderError
     */
    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        if (self::SUPPORTED_CONTENT_TYPE !== $request->getContentType()) {
            return;
        }

        $content = $this->createContent($viewEvent->getControllerResult());
        $viewEvent->setResponse((new Response())->setContent($content));
    }

    /**
     * @throws \Twig\Error\SyntaxError | \Twig\Error\RuntimeError | \Twig\Error\LoaderError
     */
    private function createContent(mixed $response): null | string
    {
        $content = null;
        if ($response instanceof TwigResponse) {
            $content = $this->twig->render($response->template(), $response->parameters());
        }

        if ($response instanceof HtmlResponse) {
            $content = $response->context();
        }

        return $content;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke'],
        ];
    }
}
