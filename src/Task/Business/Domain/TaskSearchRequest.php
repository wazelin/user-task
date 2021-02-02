<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use DateTimeInterface;
use Wazelin\UserTask\Core\Contract\IdentifiableSearchRequestInterface;
use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestTrait;

class TaskSearchRequest implements IdentifiableSearchRequestInterface
{
    use IdentifiableSearchRequestTrait;

    private ?TaskStatus        $status  = null;
    private ?DateTimeInterface $dueDate = null;

    public function hasStatus(): bool
    {
        return null !== $this->status;
    }

    public function getStatus(): string
    {
        return (string)$this->status;
    }

        public function setStatus(TaskStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function hasDueDate(): bool
    {
        return null !== $this->dueDate;
    }

    public function getDueDate(): string
    {
        return $this->dueDate->format('Y-m-d');
    }

    public function setDueDate(DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }
}
