<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\DataAccess\Event;

use Broadway\Domain\DomainEventStream;
use Broadway\EventHandling\EventBus as BroadwayEventBus;
use Broadway\EventHandling\EventListener;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements BroadwayEventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function subscribe(EventListener $eventListener): void
    {
        //noop
    }

    public function publish(DomainEventStream $domainMessages): void
    {
        foreach ($domainMessages as $domainMessage) {
            $this->eventBus->dispatch($domainMessage);
        }
    }
}
