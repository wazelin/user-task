<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Service;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;

class TaskSearchService
{
    public function __construct(private TaskRepositoryInterface $repository)
    {
    }

    public function findOneOrFail(TaskSearchQueryInterface $query): Task
    {
        $tasks = $this->find($query);

        if (!$tasks) {
            throw EntityNotFoundException::create(Task::class);
        }

        return reset($tasks);
    }

    /***
     * @param TaskSearchQueryInterface $query
     * @return Task[]
     */
    public function find(TaskSearchQueryInterface $query): array
    {
        return $this->repository->find(
            $query->getSearchRequest()
        );
    }
}
