<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Query;

use Wazelin\UserTask\Task\Business\Contract\TaskSearchQueryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;

class GetTaskQuery implements TaskSearchQueryInterface
{
    public function __construct(private string $id)
    {
    }

    public function getSearchRequest(): TaskSearchRequest
    {
        return (new TaskSearchRequest())
            ->setId($this->id);
    }
}
