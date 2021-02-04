<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\DataAccess\Repository;

use Broadway\ReadModel\ElasticSearch\ElasticSearchRepository;
use Broadway\ReadModel\ElasticSearch\ElasticSearchRepositoryFactory;
use Broadway\ReadModel\Repository;
use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestRepositoryTrait;
use Wazelin\UserTask\Task\Business\Domain\TaskCollectionProjection;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\Core\Contract\IndexableRepositoryInterface;
use Wazelin\UserTask\Task\Business\Domain\TaskProjection;

final class ElasticSearchTaskRepository implements TaskRepositoryInterface, IndexableRepositoryInterface
{
    use IdentifiableSearchRequestRepositoryTrait;

    private const NAME = 'task';

    private ElasticSearchRepository $repository;

    public function __construct(ElasticSearchRepositoryFactory $repositoryFactory)
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $repositoryFactory->create(
            self::NAME,
            TaskProjection::class,
            [
                TaskProjection::FIELD_STATUS,
                TaskProjection::FIELD_DUE_DATE,
                TaskProjection::FIELD_ASSIGNEE_ID,
            ]
        );
    }

    public function persist(TaskProjection $task): void
    {
        $this->repository->save($task);
    }

    public function find(TaskSearchRequest $searchRequest): TaskCollectionProjection
    {
        $identifiableSearchResult = $this->findByIdentifier($searchRequest);

        if (null !== $identifiableSearchResult) {
            return new TaskCollectionProjection(...$identifiableSearchResult);
        }

        $searchFields = [];

        if ($searchRequest->hasId()) {
            $searchFields[TaskProjection::FIELD_ID] = $searchRequest->getId();
        }

        if ($searchRequest->hasStatus()) {
            $searchFields[TaskProjection::FIELD_STATUS] = $searchRequest->getStatus();
        }

        if ($searchRequest->hasDueDate()) {
            $searchFields[TaskProjection::FIELD_DUE_DATE] = $searchRequest->getDueDate();
        }

        if ($searchRequest->hasAssigneeId()) {
            $searchFields[TaskProjection::FIELD_ASSIGNEE_ID] = $searchRequest->getAssigneeId();
        }

        return new TaskCollectionProjection(
            ...$this->repository->findBy($searchFields)
        );
    }

    public function findOneById(string $id): ?TaskProjection
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository->find($id);
    }

    public function createIndices(): bool
    {
        return $this->repository->createIndex();
    }

    public function dropIndices(): bool
    {
        return $this->repository->deleteIndex();
    }

    protected function getRepository(): Repository
    {
        return $this->repository;
    }
}
