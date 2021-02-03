<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain\Event;

use Wazelin\UserTask\Core\Business\Domain\Id;

class UserWasUnassignedFromTaskEvent
{
    public function __construct(private Id $userId, private Id $taskId)
    {
    }

    public function getUserId(): Id
    {
        return $this->userId;
    }

    public function getTaskId(): Id
    {
        return $this->taskId;
    }
}
