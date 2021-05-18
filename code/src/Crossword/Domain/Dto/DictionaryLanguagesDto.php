<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Dto;

use Countable;

/**
 * @psalm-immutable
 */
final class DictionaryLanguagesDto implements Countable
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function count(): int
    {
        return count($this->languages());
    }

    public function languages(): array
    {
        return $this->isSuccess() ? $this->payload['data'] : [];
    }

    private function isSuccess(): bool
    {
        return (bool) $this->payload['success'];
    }
}
