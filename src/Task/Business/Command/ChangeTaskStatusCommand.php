<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Command;

use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class ChangeTaskStatusCommand
{
    public function __construct(private Id $id, private TaskStatus $status)
    {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }
}
