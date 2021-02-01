<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Projector;

use Broadway\ReadModel\Projector;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\TaskEvent\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;

class TaskProjector extends Projector
{
    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    protected function applyTaskWasCreatedEvent(TaskWasCreatedEvent $event): void
    {
        $this->repository->persist(
            (new Task())->applyTaskWasCreatedEvent($event)
        );
    }
}
