<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use DateTimeInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskStatusWasChangedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\TaskWasCreatedEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasAssignedToTaskEvent;
use Wazelin\UserTask\Task\Business\Domain\Event\UserWasUnassignedFromTaskEvent;
use Wazelin\UserTask\User\Business\Domain\User;

final class Task extends EventSourcedAggregateRoot
{
    private Id                 $id;
    private TaskStatus         $status;
    private string             $summary;
    private string             $description;
    private ?DateTimeInterface $dueDate;
    private ?Id                $assignee = null;

    public static function create(Id $id, string $summary, string $description, ?DateTimeInterface $dueDate): self
    {
        $task = new self();

        $task->apply(
            new TaskWasCreatedEvent($id, $summary, $description, $dueDate)
        );

        return $task;
    }

    public function getAggregateRootId(): string
    {
        return (string)$this->getId();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    public function assignToUser(User $user): self
    {
        if ((string)$user->getId() === (string)$this->assignee)
        {
            return $this;
        }

        $this->unassign();

        if ($this->status->equals(TaskStatus::open())) {
            $this->apply(
                new TaskStatusWasChangedEvent(
                    $this->id,
                    TaskStatus::todo()
                )
            );
        }

        $this->apply(
            new UserWasAssignedToTaskEvent(
                $user->getId(),
                $this->id
            )
        );

        return $this;
    }

    public function unassign(): self
    {
        if (null === $this->assignee) {
            return $this;
        }

        $this->apply(
            new UserWasUnassignedFromTaskEvent(
                $this->assignee,
                $this->id
            )
        );

        $this->apply(
            new TaskStatusWasChangedEvent(
                $this->getId(),
                TaskStatus::open()
            )
        );

        return $this;
    }

    public function applyTaskWasCreatedEvent(TaskWasCreatedEvent $event): void
    {
        $this->id          = $event->getId();
        $this->status      = $event->getStatus();
        $this->summary     = $event->getSummary();
        $this->description = $event->getDescription();
        $this->dueDate     = $event->getDueDate();
    }

    public function applyUserWasAssignedToTaskEvent(UserWasAssignedToTaskEvent $event): void
    {
        $this->assignee = $event->getUserId();
    }

    public function applyUserWasUnassignedFromTaskEvent(UserWasUnassignedFromTaskEvent $event): void
    {
        if ((string)$this->assignee === (string)$event->getUserId()) {
            $this->assignee = null;
        }
    }

    public function applyTaskStatusWasChangedEvent(TaskStatusWasChangedEvent $event): void
    {
        $this->status = $event->getStatus();
    }
}
