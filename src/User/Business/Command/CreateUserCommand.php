<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Command;

use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Core\Contract\CommandInterface;

class CreateUserCommand implements CommandInterface
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
