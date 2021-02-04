<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Service;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\User\Business\Contract\UserSearchQueryInterface;
use Wazelin\UserTask\User\Business\Domain\UserCollectionProjection;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class UserSearchService
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function findOneOrFail(UserSearchQueryInterface $query): UserProjection
    {
        foreach ($this->find($query) as $user) {
            return $user;
        }

        throw EntityNotFoundException::create(UserProjection::class);
    }

    public function find(UserSearchQueryInterface $query): UserCollectionProjection
    {
        return $this->repository->find(
            $query->getSearchRequest()
        );
    }
}
