<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Command;

use Broadway\EventSourcing\EventSourcingRepository;
use Wazelin\UserTask\Core\Business\Command\AbstractCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\User\Business\Domain\User;

final class AssignCommandHandler extends AbstractCommandHandler
{
    public function __construct(
        private EventSourcingRepository $userRepository,
        private EventSourcingRepository $taskRepository
    ) {
    }

    public function __invoke(AssignCommand $command): void
    {
        /** @var User $user */
        $user = $this->userRepository->load(
            $command->getUserId()
        );

        /** @var Task $task */
        $task = $this->taskRepository->load(
            $command->getTaskId()
        );

        $this->taskRepository->save(
            $task->assignToUser($user)
        );
    }
}
