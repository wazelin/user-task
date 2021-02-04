<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Contract;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskCollectionProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

interface TaskSearchServiceInterface
{
    /**
     * @param TaskSearchQueryInterface $query
     * @return TaskProjection
     *
     * @throws EntityNotFoundException
     */
    public function findOneOrFail(TaskSearchQueryInterface $query): TaskProjection;

    public function find(TaskSearchQueryInterface $query): TaskCollectionProjection;
}
