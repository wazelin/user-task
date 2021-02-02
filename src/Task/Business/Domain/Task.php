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
            new TaskWasCreatedEvent($id, TaskStatus::open(), $summary, $description, $dueDate)
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
        $this->apply(
            new UserWasAssignedToTaskEvent(
                $this->getId(),
                $user->getId()
            )
        );

        return $this;
    }

    public function applyTaskWasCreatedEvent(TaskWasCreatedEvent $event): self
    {
        $this->id          = $event->getId();
        $this->status      = $event->getStatus();
        $this->summary     = $event->getSummary();
        $this->description = $event->getDescription();
        $this->dueDate     = $event->getDueDate();

        return $this;
    }

    public function applyUserWasAssignedToTaskEvent(UserWasAssignedToTaskEvent $event): self
    {
        if (null !== $this->assignee) {
            $this->apply(
                new UserWasUnassignedFromTaskEvent(
                    $this->getId(),
                    $this->assignee
                )
            );
        }

        $this->apply(
            new TaskStatusWasChangedEvent(
                $this->getId(),
                TaskStatus::todo()
            )
        );

        $this->assignee = $event->getUserId();

        return $this;
    }

    public function applyUserWasUnassignedFromTaskEvent(UserWasUnassignedFromTaskEvent $event): self
    {
        if ((string)$this->assignee === (string)$event->getUserId()) {
            $this->assignee = null;
        }

        $this->apply(
            new TaskStatusWasChangedEvent(
                $this->getId(),
                TaskStatus::open()
            )
        );

        return $this;
    }

    public function applyTaskStatusWasChangedEvent(TaskStatusWasChangedEvent $event): self
    {
        $this->status = $event->getStatus();

        return $this;
    }
}
