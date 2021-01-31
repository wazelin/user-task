<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\User\Business\Domain\UserEvent\UserWasCreatedEvent;

final class User extends EventSourcedAggregateRoot
{
    private Id $id;

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
        return (string)$this->id;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function applyUserWasCreatedEvent(UserWasCreatedEvent $event): void
    {
        $this->id   = $event->id;
        $this->name = $event->name;
    }
}
