<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\ReadModel\Identifiable;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\User\Business\Domain\UserEvent\UserWasCreatedEvent;

final class User extends EventSourcedAggregateRoot implements Identifiable
{
    public const FIELD_ID   = 'id';
    public const FIELD_NAME = 'name';

    private string $id;
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
        return $this->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function applyUserWasCreatedEvent(UserWasCreatedEvent $event): self
    {
        $this->id   = (string)$event->getId();
        $this->name = $event->getName();

        return $this;
    }
}
