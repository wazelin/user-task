<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain\Mapper;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskProjectionInterface;

class AssignmentProjectionMapper
{
    public function mapFromTaskProjection(TaskProjectionInterface $taskProjection): AssignmentProjection
    {
        return new AssignmentProjection(
            $taskProjection->getId(),
            $taskProjection->getStatus(),
            $taskProjection->getSummary(),
            $taskProjection->getDescription(),
            $taskProjection->getDueDate()
        );
    }
}
