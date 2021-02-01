<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\DataAccess\Repository;

use Broadway\ReadModel\ElasticSearch\ElasticSearchRepository;
use Broadway\ReadModel\ElasticSearch\ElasticSearchRepositoryFactory;
use Wazelin\UserTask\User\Business\Domain\User;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;
use Wazelin\UserTask\User\Contract\IndexableRepository;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

final class ElasticSearchUserRepository implements UserRepositoryInterface, IndexableRepository
{
    private const NAME = 'user';

    private ElasticSearchRepository $repository;

    public function __construct(ElasticSearchRepositoryFactory $repositoryFactory)
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $repositoryFactory->create(
            self::NAME,
            User::class,
            [User::FIELD_NAME]
        );
    }

    public function persist(User $user): void
    {
        $this->repository->save($user);
    }

    public function find(UserSearchRequest $searchRequest): array
    {
        if ($searchRequest->isEmpty()) {
            return $this->repository->findAll();
        }

        if ($searchRequest->hasIdOnly()) {
            $user = $this->repository->find($searchRequest->getId());

            return $user ? [$user] : [];
        }

        $searchFields = [];

        if ($searchRequest->hasId()) {
            $searchFields[User::FIELD_ID] = $searchRequest->getId();
        }

        if ($searchRequest->hasName()) {
            $searchFields[User::FIELD_NAME] = $searchRequest->getName();
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
}
