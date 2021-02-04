<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Command;

use Broadway\EventSourcing\EventSourcingRepository;
use Wazelin\UserTask\Core\Command\AbstractCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Task;

class ChangeTaskStatusCommandHandler extends AbstractCommandHandler
{
    public function __construct(private EventSourcingRepository $taskRepository)
    {
    }

    public function __invoke(ChangeTaskStatusCommand $command): void
    {
        /** @var Task $task */
        $task = $this->taskRepository->load(
            $command->getId()
        );

        if (null === $task) {
            return;
        }

        $this->taskRepository->save(
            $task->changeStatus(
                $command->getStatus()
            )
        );
    }
}
