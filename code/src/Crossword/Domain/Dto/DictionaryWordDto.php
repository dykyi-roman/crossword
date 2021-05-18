<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

use Countable;

/**
 * @psalm-immutable
 */
final class DictionaryWordDto implements Countable
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function count(): int
    {
        return $this->payload['success'] ? 1 : 0;
    }

    public function word(): string
    {
        return $this->isSuccess() ? $this->payload['data'][0]['word'] : '';
    }

    public function definition(): string
    {
        return $this->isSuccess() ? $this->payload['data'][0]['definition'] : '';
    }

    private function isSuccess(): bool
    {
        return (bool) $this->payload['success'];
    }
}
