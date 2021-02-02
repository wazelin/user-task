<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain\ReadModel;

use Broadway\ReadModel\Identifiable;
use DateTimeInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;
use Wazelin\UserTask\User\Business\Domain\ReadModel\User;

final class Task implements Identifiable
{
    public const FIELD_ID       = 'id';
    public const FIELD_STATUS   = 'status';
    public const FIELD_DUE_DATE = 'dueDate';

    private ?User $assignee = null;

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

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }
}
