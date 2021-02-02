<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Command;

use Wazelin\UserTask\Core\Business\Domain\Id;

class AssignCommand
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
