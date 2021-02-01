<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Command;

use DateTimeInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;

class CreateTaskCommand
{
    public function __construct(
        private Id $id,
        private string $summary,
        private string $description,
        private ?DateTimeInterface $dueDate
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
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
