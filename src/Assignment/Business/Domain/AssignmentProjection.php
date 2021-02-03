<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain;

use DateTimeInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

final class AssignmentProjection implements TaskProjectionInterface
{
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
}
