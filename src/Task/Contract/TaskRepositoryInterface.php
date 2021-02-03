<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Contract;

use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

interface TaskRepositoryInterface
{
    public function persist(TaskProjection $task);

    /**
     * @param TaskSearchRequest $searchRequest
     * @return TaskProjection[]
     */
    public function find(TaskSearchRequest $searchRequest): array;

    public function findOneById(string $id): ?TaskProjection;
}
