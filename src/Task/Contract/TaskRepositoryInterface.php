<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Contract;

use Wazelin\UserTask\Task\Business\Domain\TaskCollectionProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

interface TaskRepositoryInterface
{
    public function persist(TaskProjection $task);

    public function find(TaskSearchRequest $searchRequest): TaskCollectionProjection;

    public function findOneById(string $id): ?TaskProjection;
}
