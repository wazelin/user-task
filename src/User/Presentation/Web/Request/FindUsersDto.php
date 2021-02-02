<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Request;

class FindUsersDto
{
    public function __construct(private ?string $name = null)
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
