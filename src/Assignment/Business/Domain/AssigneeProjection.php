<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain;

use Wazelin\UserTask\User\Business\Domain\UserProjectionInterface;

final class AssigneeProjection implements UserProjectionInterface
{
    public function __construct(private string $id, private string $name)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
