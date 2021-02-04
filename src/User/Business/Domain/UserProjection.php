<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentCollectionProjection;
use Wazelin\UserTask\Assignment\Business\Domain\AssignmentProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

final class UserProjection implements UserProjectionInterface
{
    public const FIELD_ID   = 'id';
    public const FIELD_NAME = 'name';

    private AssignmentCollectionProjection $tasks;

    public function __construct(private string $id, private string $name)
    {
        $this->tasks = new AssignmentCollectionProjection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTasks(): AssignmentCollectionProjection
    {
        return $this->tasks;
    }

    public function setTasks(AssignmentCollectionProjection $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    public function assign(AssignmentProjection $task): self
    {
        $this->tasks->include($task);

        return $this;
    }

    public function unassign(TaskProjectionInterface $task): self
    {
        $this->tasks->exclude($task);

        return $this;
    }
}
