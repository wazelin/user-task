<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use DateTimeInterface;
use Wazelin\UserTask\Assignment\Business\Domain\AssigneeProjection;

final class TaskProjection implements TaskProjectionInterface
{
    public const FIELD_ID       = 'id';
    public const FIELD_STATUS   = 'status';
    public const FIELD_DUE_DATE = 'dueDate';

    private ?AssigneeProjection $assignee = null;

    public function __construct(
        private string $id,
        private TaskStatus $status,
        private string $summary,
        private string $description,
        private ?DateTimeInterface $dueDate
    ) {
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getAssignee(): ?AssigneeProjection
    {
        return $this->assignee;
    }

    public function setAssignee(?AssigneeProjection $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }
}
