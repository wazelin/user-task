<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain\Event;

use DateTimeInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;
use Wazelin\UserTask\Task\Business\Domain\TaskStatus;

class TaskWasCreatedEvent
{
    public function __construct(
        private Id $id,
        private TaskStatus $status,
        private string $summary,
        private string $description,
        private ?DateTimeInterface $dueDate
    ) {
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
}
