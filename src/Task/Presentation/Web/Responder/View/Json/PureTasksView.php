<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

class PureTasksView implements JsonSerializable
{
    private array $tasks;

    public function __construct(TaskProjectionInterface ...$tasks)
    {
        $this->tasks = array_values($tasks);
    }

    public function jsonSerialize()
    {
        return array_map(
            static fn(TaskProjectionInterface $task): PureTaskView => new PureTaskView($task),
            $this->tasks
        );
    }
}
