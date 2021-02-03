<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use Broadway\ReadModel\Identifiable;
use DateTimeInterface;

interface TaskProjectionInterface extends Identifiable
{
    public function getStatus(): TaskStatus;

    public function getSummary(): string;

    public function getDescription(): string;

    public function getDueDate(): ?DateTimeInterface;
}
