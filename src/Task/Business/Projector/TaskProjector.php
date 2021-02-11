<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Projector;

use Broadway\ReadModel\Projector;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Wazelin\UserTask\Core\Traits\ProjectorTrait;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskStatusWasChangedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

class TaskProjector extends Projector implements MessageHandlerInterface
{
    use ProjectorTrait;

    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    protected function applyTaskWasCreatedEvent(TaskWasCreatedEvent $event): void
    {
        $this->repository->persist(
            new TaskProjection(
                (string)$event->getId(),
                $event->getStatus(),
                $event->getSummary(),
                $event->getDescription(),
                $event->getDueDate()
            )
        );
    }

    protected function applyTaskStatusWasChangedEvent(TaskStatusWasChangedEvent $event): void
    {
        $task = $this->repository->findOneById((string)$event->getTaskId());

        if (null === $task) {
            return;
        }

        $this->repository->persist(
            $task->setStatus(
                $event->getStatus()
            )
        );
    }
}
