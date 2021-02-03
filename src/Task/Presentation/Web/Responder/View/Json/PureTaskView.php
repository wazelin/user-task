<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

class PureTaskView implements JsonSerializable
{
    public function __construct(private TaskProjectionInterface $task)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id'          => $this->task->getId(),
            'status'      => (string)$this->task->getStatus(),
            'summary'     => $this->task->getSummary(),
            'description' => $this->task->getDescription(),
            'dueDate'     => $this->task->getDueDate()?->format('Y-m-d'),
        ];
    }
}
