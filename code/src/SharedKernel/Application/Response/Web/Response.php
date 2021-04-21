<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Response\Web;

final class Response
{
    private string $template;
    private array $parameters;

    public function __construct(string $template, array $parameters = [])
    {
        $this->template = $template;
        $this->parameters = $parameters;
    }

    public function template(): string
    {
        return $this->template;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
