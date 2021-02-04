<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use Countable;
use IteratorAggregate;
use Wazelin\UserTask\Core\Contract\DomainIterator;

class TaskCollectionProjection implements DomainIterator, IteratorAggregate, Countable
{
    /** @var TaskProjection[] */
    private array $taskProjections;

    public function __construct(TaskProjection ...$taskProjections)
    {
        $this->taskProjections = $taskProjections;
    }

    /**
     * @return TaskProjection[]
     */
    public function getIterator(): iterable
    {
        yield from $this->taskProjections;
    }

    public function count(): int
    {
        return count($this->taskProjections);
    }
}
