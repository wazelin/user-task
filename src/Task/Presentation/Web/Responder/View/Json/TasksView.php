<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

class TasksView implements JsonSerializable
{
    private array $tasks;

    public function __construct(TaskProjection ...$tasks)
    {
        $this->tasks = $tasks;
    }

    public function jsonSerialize()
    {
        return array_map(
            static fn(TaskProjection $task): TaskView => new TaskView($task),
            $this->tasks
        );
    }
}
