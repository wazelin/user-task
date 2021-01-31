<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Command;

use Wazelin\UserTask\Core\Business\Domain\Id;

class CreateUserCommand
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
