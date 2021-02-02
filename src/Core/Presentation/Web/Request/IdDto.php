<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class IdDto
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    private ?string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
