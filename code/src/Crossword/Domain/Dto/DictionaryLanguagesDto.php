<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

final class DictionaryLanguagesDto
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function languages(): array
    {
        return $this->isSuccess() ? $this->payload['data'] : [];
    }

    private function isSuccess(): bool
    {
        return 'success' === $this->payload['status'];
    }
}
