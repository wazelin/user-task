<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\ReadModel\Identifiable;
use DateTimeInterface;
use JetBrains\PhpStorm\Pure;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\TaskEvent\TaskWasCreatedEvent;

final class Task extends EventSourcedAggregateRoot implements Identifiable
{
    public const FIELD_ID          = 'id';
    public const FIELD_STATUS      = 'status';
    public const FIELD_SUMMARY     = 'summary';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_DUE_DATE    = 'dueDate';

    private string             $id;
    private TaskStatus         $status;
    private string             $summary;
    private string             $description;
    private ?DateTimeInterface $dueDate;

    public static function create(Id $id, string $summary, string $description, ?DateTimeInterface $dueDate): self
    {
        $task = new self();

        $task->apply(
            new TaskWasCreatedEvent($id, $summary, $description, $dueDate)
        );

        return $task;
    }

    #[Pure] public function getAggregateRootId(): string
    {
        return $this->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(?DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function applyTaskWasCreatedEvent(TaskWasCreatedEvent $event): self
    {
        $this->id          = (string)$event->getId();
        $this->status      = TaskStatus::open();
        $this->summary     = $event->getSummary();
        $this->description = $event->getDescription();

        return $this;
    }
}
