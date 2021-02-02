<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class FindTasksDto
{
    /**
     * @Assert\Choice(choices=TaskStatus::VALUES)
     */
    private ?string $status;

    /**
     * @Assert\DateTime(format="Y-m-d")
     */
    private ?string $dueDate;

    public function __construct(string $status = null, string $dueDate = null)
    {
        $this->status  = $status;
        $this->dueDate = $dueDate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }
}
