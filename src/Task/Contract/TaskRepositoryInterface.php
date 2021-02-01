<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Contract;

use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;

interface TaskRepositoryInterface
{
    public function persist(Task $task);

    /**
     * @param TaskSearchRequest $searchRequest
     * @return Task[]
     */
    public function find(TaskSearchRequest $searchRequest): array;
}
