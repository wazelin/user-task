<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\Task\Presentation\Web\Responder\View\Json\PureTasksView;
use Wazelin\UserTask\User\Business\Domain\UserProjection;

class UserView implements JsonSerializable
{
    public function __construct(private UserProjection $user)
    {
    }

    public function jsonSerialize(): array
    {
        return array_replace(
            (new PureUserView($this->user))->jsonSerialize(),
            [
                'tasks' => new PureTasksView(...$this->user->getTasks()),
            ]
        );
    }
}
