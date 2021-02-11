<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Projector;

use Broadway\ReadModel\Projector;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Wazelin\UserTask\Assignment\Business\Domain\Mapper\AssigneeProjectionMapper;
use Wazelin\UserTask\Assignment\Business\Domain\Mapper\AssignmentProjectionMapper;
use Wazelin\UserTask\Core\Traits\ProjectorTrait;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasAssignedToTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasUnassignedFromTaskEvent;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class AssignmentProjector extends Projector implements MessageHandlerInterface
{
    use ProjectorTrait;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskRepositoryInterface $taskRepository,
        private AssigneeProjectionMapper $assigneeProjectionMapper,
        private AssignmentProjectionMapper $assignmentProjectionMapper
    ) {
    }

    protected function applyUserWasAssignedToTaskEvent(UserWasAssignedToTaskEvent $event): void
    {
        $task = $this->taskRepository->findOneById((string)$event->getTaskId());
        $user = $this->userRepository->findOneById((string)$event->getUserId());

        if (!isset($task, $user)) {
            return;
        }

        $task->setAssignee(
            $this->assigneeProjectionMapper->mapFromUserProjection($user)
        );
        $user->assign(
            $this->assignmentProjectionMapper->mapFromTaskProjection($task)
        );

        $this->taskRepository->persist($task);
        $this->userRepository->persist($user);
    }

    protected function applyUserWasUnassignedFromTaskEvent(UserWasUnassignedFromTaskEvent $event): void
    {
        $task = $this->taskRepository->findOneById((string)$event->getTaskId());
        $user = $this->userRepository->findOneById((string)$event->getUserId());

        if (!isset($task, $user)) {
            return;
        }

        $task->setAssignee(null);
        $user->unassign($task);

        $this->taskRepository->persist($task);
        $this->userRepository->persist($user);
    }
}
