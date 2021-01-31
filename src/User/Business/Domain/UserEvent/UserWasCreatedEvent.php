<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain\UserEvent;

use Broadway\Serializer\Serializable;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Traits\SerializableTrait;

final class UserWasCreatedEvent implements Serializable
{
    use SerializableTrait;

    public function __construct(public Id $id, public string $name)
    {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected static function getProperties(): array
    {
        return [
            'id',
            'name',
        ];
    }
}
