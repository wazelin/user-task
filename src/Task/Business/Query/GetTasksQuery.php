<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Query;

use DateTimeInterface;
use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class GetTasksQuery implements TaskSearchQueryInterface
{
    public function __construct(
        private ?TaskStatus $status,
        private ?DateTimeInterface $dueDate
    ) {
    }

    public function getSearchRequest(): TaskSearchRequest
    {
        $searchRequest = new TaskSearchRequest();

        if (isset($this->status)) {
            $searchRequest->setStatus($this->status);
        }

        if (isset($this->dueDate)) {
            $searchRequest->setDueDate($this->dueDate);
        }

        return $searchRequest;
    }
}
