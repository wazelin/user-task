<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;
use Wazelin\UserTask\User\Presentation\Web\Responder\View\Json\PureUserView;

class TaskView implements JsonSerializable
{
    public function __construct(private TaskProjection $task)
    {
    }

    public function jsonSerialize(): array
    {
        return array_replace(
            (new PureTaskView($this->task))->jsonSerialize(),
            [
                'assignee' => null === $this->task->getAssignee()
                    ? null
                    : new PureUserView($this->task->getAssignee()),
            ]
        );
    }
}
