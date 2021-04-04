<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

final class WikipediaWordDefinitionDto
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function word(): ?string
    {
        $pages = array_values($this->payload['query']['pages']);
        $text = $pages[0]['extract'];
        if ($text && ((false === stripos($text, 'refer to')) || (false === stripos($text, 'refers to')))) {
            return explode('.', $text)[0];
        }

        return null;
    }
}
