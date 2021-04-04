<?php

declare(strict_types=1);

namespace App\Dictionary\Domain\Dto;

final class GoogleWordDefinitionDto
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function word(): ?string
    {
        if (array_key_exists('resolution', $this->payload) && array_key_exists('message', $this->payload)) {
            return null;
        }

        return $this->payload[0]['meanings'][0]['definitions'][0]['definition'];
    }
}
