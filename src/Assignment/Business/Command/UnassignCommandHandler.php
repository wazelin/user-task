<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Command;

use Broadway\EventSourcing\EventSourcingRepository;
use Wazelin\UserTask\Core\Business\Command\AbstractCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Task;

final class UnassignCommandHandler extends AbstractCommandHandler
{
    public function __construct(
        private EventSourcingRepository $userRepository,
        private EventSourcingRepository $taskRepository
    ) {
    }

    public function __invoke(UnassignCommand $command): void
    {
        /** @var Task $task */
        $task = $this->taskRepository->load(
            $command->getTaskId()
        );

        $this->taskRepository->save(
            $task->unassign()
        );
    }
}
