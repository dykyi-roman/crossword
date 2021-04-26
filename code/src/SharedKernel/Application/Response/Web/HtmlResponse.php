<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response\Web;

final class HtmlResponse implements ResponseInterface
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function context(): string
    {
        return $this->content;
    }
}
