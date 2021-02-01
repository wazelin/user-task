<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestTrait;

class UserSearchRequest
{
    use IdentifiableSearchRequestTrait;

    private ?string $name = null;

    public function hasName(): bool
    {
        return null !== $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
