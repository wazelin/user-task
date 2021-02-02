<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Projector;

use Broadway\ReadModel\Projector;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasAssignedToTaskEvent;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class AssignmentProjector extends Projector
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskRepositoryInterface $taskRepository
    ) {
    }

    protected function applyUserWasAssignedToTaskEvent(UserWasAssignedToTaskEvent $event): void
    {
        $task = $this->taskRepository->findOneById((string)$event->getTaskId());
        $user = $this->userRepository->findOneById((string)$event->getUserId());

        if (!isset($task, $user)) {
            return;
        }

        $task->setAssignee($user);
        $user->assign($task);
    }
}
