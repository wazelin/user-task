<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

final class UserProjection implements UserProjectionInterface
{
    public const FIELD_ID   = 'id';
    public const FIELD_NAME = 'name';

    /** @var array<string, AssignmentProjection> */
    private array $tasks = [];

    public function __construct(private string $id, private string $name)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function setTasks(array $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    public function assign(AssignmentProjection $task): self
    {
        $this->tasks[$task->getId()] = $task;

        return $this;
    }

    public function unassign(TaskProjectionInterface $task): self
    {
        unset($this->tasks[$task->getId()]);

        return $this;
    }
}
