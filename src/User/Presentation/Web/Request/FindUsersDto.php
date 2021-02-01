<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class FindUsersDto
{
    /**
     * @Assert\Uuid
     */
    private ?string $id;
    private ?string $name;

    public function __construct(string $id = null, string $name = null)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
