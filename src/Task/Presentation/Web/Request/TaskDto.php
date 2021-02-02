<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;

class TaskDto
{
    /**
     * @Assert\NotBlank
     */
    private ?string $summary;

    /**
     * @Assert\NotBlank
     */
    private ?string $description;

    /**
     * @Assert\DateTime(format="Y-m-d")
     */
    private ?string $dueDate;

    public function __construct(string $summary = null, string $description = null, string $dueDate = null)
    {
        $this->summary     = $summary;
        $this->description = $description;
        $this->dueDate     = $dueDate;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }
}
