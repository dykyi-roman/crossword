<?php

declare(strict_types=1);

namespace App\Game\Features\Player;

abstract class AggregateRoot implements RaiseEventsInterface
{
    /**
     * @var DomainEventInterface[]
     */
    protected array $events = [];

    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }

    public function raise(DomainEventInterface $event): void
    {
        $this->events[] = $event;
    }
}
