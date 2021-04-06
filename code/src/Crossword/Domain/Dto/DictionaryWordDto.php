<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

/**
 * @psalm-immutable
 */
final class DictionaryWordDto
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function isSuccess(): bool
    {
        return 'success' === $this->payload['status'];
    }

    public function word(): string
    {
        return $this->isSuccess() ? $this->payload['data'][0]['word'] : '';
    }

    public function definition(): string
    {
        return $this->isSuccess() ? $this->payload['data'][0]['definition'] : '';
    }
}
