<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\User\Business\Domain\Event\UserWasCreatedEvent;

final class User extends EventSourcedAggregateRoot
{
    private Id     $id;
    private string $name;

    public static function create(Id $id, string $name): self
    {
        $user = new self();

        $user->apply(
            new UserWasCreatedEvent($id, $name)
        );

        return $user;
    }

    public function getAggregateRootId(): string
    {
        return (string)$this->getId();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function applyUserWasCreatedEvent(UserWasCreatedEvent $event): self
    {
        $this->id   = $event->getId();
        $this->name = $event->getName();

        return $this;
    }
}
