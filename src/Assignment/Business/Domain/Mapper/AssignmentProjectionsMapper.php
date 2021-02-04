<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Domain\Mapper;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentCollectionProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskCollectionProjection;

class AssignmentProjectionsMapper
{
    public function __construct(private AssignmentProjectionMapper $mapper)
    {
    }

    public function mapFromTaskProjections(TaskCollectionProjection $taskProjections): AssignmentCollectionProjection
    {
        $assigmentProjections = new AssignmentCollectionProjection();

        foreach ($taskProjections as $taskProjection) {
            $assigmentProjections->include(
                $this->mapper->mapFromTaskProjection($taskProjection)
            );
        }

        return $assigmentProjections;
    }
}
