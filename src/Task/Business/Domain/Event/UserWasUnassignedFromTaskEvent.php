<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain\Event;

use Wazelin\UserTask\Core\Business\Domain\Id;

class UserWasUnassignedFromTaskEvent
{
    public function __construct(private Id $taskId, private Id $userId)
    {
    }

    public function getTaskId(): Id
    {
        return $this->taskId;
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }
}
