<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\Task;

class TasksView implements JsonSerializable
{
    private array $tasks;

    public function __construct(Task ...$tasks)
    {
        $this->tasks = $tasks;
    }

    public function jsonSerialize()
    {
        return array_map(
            static fn(Task $task): TaskView => new TaskView($task),
            $this->tasks
        );
    }
}
