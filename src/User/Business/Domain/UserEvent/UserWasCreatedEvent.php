<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain\UserEvent;

use Wazelin\UserTask\Core\Business\Domain\Id;

final class UserWasCreatedEvent
{
    public function __construct(private Id $id, private string $name)
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
}
