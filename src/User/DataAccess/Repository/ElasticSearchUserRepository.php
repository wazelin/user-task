<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\DataAccess\Repository;

use Broadway\ReadModel\ElasticSearch\ElasticSearchRepository;
use Broadway\ReadModel\ElasticSearch\ElasticSearchRepositoryFactory;
use Broadway\ReadModel\Repository;
use Wazelin\UserTask\Core\Traits\IdentifiableSearchRequestRepositoryTrait;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;
use Wazelin\UserTask\Core\Contract\IndexableRepositoryInterface;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

final class ElasticSearchUserRepository implements UserRepositoryInterface, IndexableRepositoryInterface
{
    use IdentifiableSearchRequestRepositoryTrait;

    private const NAME = 'user';

    private ElasticSearchRepository $repository;

    public function __construct(ElasticSearchRepositoryFactory $repositoryFactory)
    {
        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->repository = $repositoryFactory->create(
            self::NAME,
            UserProjection::class,
            [
                UserProjection::FIELD_NAME,
            ]
        );
    }

    public function persist(UserProjection $user): void
    {
        $this->repository->save($user);
    }

    public function find(UserSearchRequest $searchRequest): array
    {
        $identifiableSearchResult = $this->findByIdentifier($searchRequest);

        if (null !== $identifiableSearchResult) {
            return $identifiableSearchResult;
        }

        $searchFields = [];

        if ($searchRequest->hasId()) {
            $searchFields[UserProjection::FIELD_ID] = $searchRequest->getId();
        }

        if ($searchRequest->hasName()) {
            $searchFields[UserProjection::FIELD_NAME] = $searchRequest->getName();
        }

        return $this->repository->findBy($searchFields);
    }

    public function findOneById(string $id): ?UserProjection
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
