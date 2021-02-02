<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain\ReadModel;

use Broadway\ReadModel\Identifiable;
use Wazelin\UserTask\Task\Business\Domain\ReadModel\Task;

class User implements Identifiable
{
    public const FIELD_ID   = 'id';
    public const FIELD_NAME = 'name';

    /**
     * @var Task[]
     */
    private $tasks = [];

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

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function assign(Task $task): self
    {
        $this->tasks[$task->getId()] = $task;

        return $this;
    }

    public function unassign(Task $task): self
    {
        unset($this->tasks[$task->getId()]);

        return $this;
    }
}
