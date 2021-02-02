<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\DataAccess\Repository;

use Broadway\ReadModel\ElasticSearch\ElasticSearchRepository;
use Broadway\ReadModel\ElasticSearch\ElasticSearchRepositoryFactory;
use Broadway\ReadModel\Repository;
use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestRepositoryTrait;
use Wazelin\UserTask\Task\Business\Domain\Task;
use Wazelin\UserTask\Task\Business\Domain\TaskSearchRequest;
use Wazelin\UserTask\Task\Contract\TaskRepositoryInterface;
use Wazelin\UserTask\Core\Contract\IndexableRepositoryInterface;

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
            Task::class,
            [
                Task::FIELD_STATUS,
                TASK::FIELD_DUE_DATE,
            ]
        );
    }

    public function persist(Task $task): void
    {
        $this->repository->save($task);
    }

    public function find(TaskSearchRequest $searchRequest): array
    {
        $identifiableSearchResult = $this->findByIdentifier($searchRequest);

        if (null !== $identifiableSearchResult) {
            return $identifiableSearchResult;
        }

        $searchFields = [];

        if ($searchRequest->hasId()) {
            $searchFields[Task::FIELD_ID] = $searchRequest->getId();
        }

        if ($searchRequest->hasStatus()) {
            $searchFields[Task::FIELD_STATUS] = $searchRequest->getStatus();
        }

        if ($searchRequest->hasDueDate()) {
            $searchFields[Task::FIELD_DUE_DATE] = $searchRequest->getDueDate();
        }

        return $this->repository->findBy($searchFields);
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
