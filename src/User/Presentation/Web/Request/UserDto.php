<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    /**
     * @Assert\NotBlank
     */
    private ?string $name;

    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
