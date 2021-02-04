<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class PatchTaskDto
{
    /**
     * @Assert\Choice(choices=TaskStatus::VALUES)
     */
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
