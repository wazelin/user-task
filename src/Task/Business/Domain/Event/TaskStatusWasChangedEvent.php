<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain\Event;

use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class TaskStatusWasChangedEvent
{
    public function __construct(private Id $taskId, private TaskStatus $status)
    {
    }

    public function getTaskId(): Id
    {
        return $this->taskId;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }
}
