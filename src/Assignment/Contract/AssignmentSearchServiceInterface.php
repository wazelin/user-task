<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Contract;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentCollectionProjection;
use Wazelin\UserTask\Assignment\Business\Query\AssignmentsSearchQuery;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;

interface AssignmentSearchServiceInterface
{
    /**
     * @param AssignmentsSearchQuery $query
     * @return AssignmentCollectionProjection
     *
     * @throws EntityNotFoundException
     */
    public function find(AssignmentsSearchQuery $query): AssignmentCollectionProjection;
}
