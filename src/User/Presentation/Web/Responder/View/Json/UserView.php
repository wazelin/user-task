<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json\TasksView;
use Wazelin\UserTask\User\Business\Domain\ReadModel\User;

class UserView implements JsonSerializable
{
    public function __construct(private User $user)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->user->getId(),
            'name'  => $this->user->getName(),
            'tasks' => new TasksView(...$this->user->getTasks()),
        ];
    }
}
