<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Contract;

use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;

interface TaskSearchQueryInterface
{
    public function getSearchRequest(): TaskSearchRequest;
}
