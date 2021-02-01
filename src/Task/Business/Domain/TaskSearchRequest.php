<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use DateTimeInterface;
use Wazelin\UserTask\Core\Contract\IdentifiableSearchRequestInterface;
use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestTrait;

class TaskSearchRequest implements IdentifiableSearchRequestInterface
{
    use IdentifiableSearchRequestTrait;

    private ?string            $summary = null;
    private ?DateTimeInterface $dueDate = null;

    public function hasSummary(): bool
    {
        return null !== $this->summary;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function hasDueDate(): bool
    {
        return null !== $this->dueDate;
    }

    public function getDueDate(): DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }
}
