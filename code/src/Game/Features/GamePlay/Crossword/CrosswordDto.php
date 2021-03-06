<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Crossword;

use Countable;

/**
 * @psalm-immutable
 */
final class CrosswordDto implements Countable
{
    private array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function count(): int
    {
        return count($this->crossword());
    }

    public function crossword(): array
    {
        return $this->isSuccess() ? $this->payload['data'] : [];
    }

    private function isSuccess(): bool
    {
        return (bool) $this->payload['success'];
    }
}
