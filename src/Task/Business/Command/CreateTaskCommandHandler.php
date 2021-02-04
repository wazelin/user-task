<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Command;

use Broadway\EventSourcing\EventSourcingRepository;
use Wazelin\UserTask\Core\Business\Command\AbstractCommandHandler;
use Wazelin\UserTask\Task\Business\Domain\Task;

class CreateTaskCommandHandler extends AbstractCommandHandler
{
    public function __construct(private EventSourcingRepository $taskRepository)
    {
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        $this->taskRepository->save(
            Task::create(
                $command->getId(),
                $command->getSummary(),
                $command->getDescription(),
                $command->getDueDate(),
            )
        );
    }
}
