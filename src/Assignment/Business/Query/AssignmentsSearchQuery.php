<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Query;

use DateTimeInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\Task\Business\Query\GetTasksQuery;

class AssignmentsSearchQuery
{
    public function __construct(
        private string $assigneeId,
        private ?TaskStatus $status,
        private ?DateTimeInterface $dueDate
    ) {
    }

    public function getAssigneeId(): string
    {
        return $this->assigneeId;
    }

    public function getTasksSearchRequest(): TaskSearchRequest
    {
        return (new GetTasksQuery($this->status, $this->dueDate))
            ->getSearchRequest()
            ->setAssigneeId($this->assigneeId);
    }
}
