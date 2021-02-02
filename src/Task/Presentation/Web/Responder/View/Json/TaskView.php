<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\ReadModel\Task;
use Wazelin\UserTask\User\Presentation\Web\Responder\View\Json\UserView;

class TaskView implements JsonSerializable
{
    public function __construct(private Task $task)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id'          => $this->task->getId(),
            'assignee'    => null === $this->task->getAssignee()
                ? null
                : new UserView($this->task->getAssignee()),
            'status'      => (string)$this->task->getStatus(),
            'summary'     => $this->task->getSummary(),
            'description' => $this->task->getDescription(),
            'dueDate'     => $this->task->getDueDate()?->format('Y-m-d'),
        ];
    }
}
