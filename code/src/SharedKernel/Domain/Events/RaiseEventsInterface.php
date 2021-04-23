<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Events;

interface RaiseEventsInterface
{
    public function popEvents(): array;

    public function raise(DomainEventInterface $event): void;

    public function clearEvents(): void;
}
