<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\ReadModel\SerializableReadModel;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Traits\SerializableTrait;
use Wazelin\UserTask\User\Business\Domain\UserEvent\UserWasCreatedEvent;

final class User extends EventSourcedAggregateRoot implements SerializableReadModel
{
    use SerializableTrait;

    public const FIELD_ID   = 'id';
    public const FIELD_NAME = 'name';

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

    public static function deserialize(array $data): self
    {
        $data[self::FIELD_ID] = new Id($data[self::FIELD_ID] ?? '');

        $user = new self();

        foreach ($data as $property => $value) {
            $user->$property = $value;
        }

        return $user;
    }

    public function getAggregateRootId(): string
    {
        return (string)$this->id;
    }

    public function getId(): string
    {
        return (string)$this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function applyUserWasCreatedEvent(UserWasCreatedEvent $event): self
    {
        $this->id   = $event->id;
        $this->name = $event->name;

        return $this;
    }

    protected static function getProperties(): array
    {
        return [
            self::FIELD_ID,
            self::FIELD_NAME
        ];
    }
}
