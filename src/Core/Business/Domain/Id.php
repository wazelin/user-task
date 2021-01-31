<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Business\Domain;

use Symfony\Component\Validator\Constraints as Assert;

final class Id
{
    /**
     * @Assert\Uuid
     */
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
