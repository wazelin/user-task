<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain;

use Countable;
use IteratorAggregate;
use Wazelin\UserTask\Core\Contract\DomainIterator;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

final class AssignmentCollectionProjection implements DomainIterator, IteratorAggregate, Countable
{
    /** @var array<string, AssignmentProjection> */
    private array $assignmentProjections = [];

    public function __construct(AssignmentProjection ...$assignmentProjections)
    {
        foreach ($assignmentProjections as $assignmentProjection) {
            $this->assignmentProjections[$assignmentProjection->getId()] = $assignmentProjection;
        }
    }

    public function include(AssignmentProjection $assignmentProjection): self
    {
        $this->assignmentProjections[$assignmentProjection->getId()] = $assignmentProjection;

        return $this;
    }

    public function exclude(TaskProjectionInterface $assignmentProjection): self
    {
        unset($this->assignmentProjections[$assignmentProjection->getId()]);

        return $this;
    }

    /**
     * @return AssignmentProjection[]
     */
    public function getIterator(): iterable
    {
        yield from $this->assignmentProjections;
    }

    public function count(): int
    {
        return count($this->assignmentProjections);
    }
}
