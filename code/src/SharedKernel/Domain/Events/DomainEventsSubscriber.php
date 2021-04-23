<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Events;

use Countable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\MessageBusInterface;

final class DomainEventsSubscriber implements EventSubscriber, Countable
{
    /**
     * @var DomainEventInterface[]
     */
    private array $events = [];
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function count(): int
    {
        return count($this->events);
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
            Events::postFlush,
        ];
    }

    public function postUpdate(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function postPersist(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function postRemove(LifecycleEventArgs $event): void
    {
        $this->doCollect($event);
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        $this->dispatchCollectedEvents();
    }

    private function doCollect(LifecycleEventArgs $event): void
    {
        $entity = $event->getEntity();
        if (!$entity instanceof RaiseEventsInterface) {
            return;
        }

        foreach ($entity->popEvents() as $item) {
            $this->events[spl_object_hash($item)] = $item;
        }
    }

    private function dispatchCollectedEvents(): void
    {
        $events = $this->events;
        $this->events = [];

        foreach ($events as $event) {
            $this->messageBus->dispatch($event);
        }

        $this->count() && $this->dispatchCollectedEvents();
    }
}
