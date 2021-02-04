<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Assignment\Business\Service;

use Wazelin\UserTask\Assignment\Business\Domain\AssignmentCollectionProjection;
use Wazelin\UserTask\Assignment\Business\Domain\Mapper\AssignmentProjectionsMapper;
use Wazelin\UserTask\Assignment\Business\Query\AssignmentsSearchQuery;
use Wazelin\UserTask\Assignment\Contract\AssignmentSearchServiceInterface;
use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class AssignmentSearchService implements AssignmentSearchServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskRepositoryInterface $taskRepository,
        private AssignmentProjectionsMapper $mapper,
    ) {
    }

    public function find(AssignmentsSearchQuery $query): AssignmentCollectionProjection
    {
        $taskSearchRequest = $query->getTasksSearchRequest();

        if ($taskSearchRequest->isEmpty()) {
            $assignee = $this->userRepository->findOneById(
                $query->getAssigneeId()
            );

            if (null === $assignee) {
                throw EntityNotFoundException::create(UserProjection::class);
            }

            return $assignee->getTasks();
        }

        return $this->mapper->mapFromTaskProjections(
            $this->taskRepository->find($taskSearchRequest)
        );
    }
}
