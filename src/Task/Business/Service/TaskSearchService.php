<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Service;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

class TaskSearchService
{
    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    public function findOneOrFail(TaskSearchQueryInterface $query): TaskProjection
    {
        $tasks = $this->find($query);

        if (!$tasks) {
            throw EntityNotFoundException::create(TaskProjection::class);
        }

        return reset($tasks);
    }

    /***
     * @param TaskSearchQueryInterface $query
     * @return TaskProjection[]
     */
    public function find(TaskSearchQueryInterface $query): array
    {
        return $this->repository->find(
            $query->getSearchRequest()
        );
    }
}
