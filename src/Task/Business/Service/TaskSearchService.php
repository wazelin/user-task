<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Service;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskCollectionProjection;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;
use Wazelin\UserTask\Task\Contract\TaskSearchServiceInterface;

class TaskSearchService implements TaskSearchServiceInterface
{
    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    public function findOneOrFail(TaskSearchQueryInterface $query): TaskProjection
    {
        foreach ($this->find($query) as $task) {
            return $task;
        }

        throw EntityNotFoundException::create(TaskProjection::class);
    }

    public function find(TaskSearchQueryInterface $query): TaskCollectionProjection
    {
        return $this->repository->find(
            $query->getSearchRequest()
        );
    }
}
