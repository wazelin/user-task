<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Contract;

use Wazelin\UserTask\User\Business\Domain\UserCollectionProjection;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;

interface UserRepositoryInterface
{
    public function persist(UserProjection $user);

    public function find(UserSearchRequest $searchRequest): UserCollectionProjection;

    public function findOneById(string $id): ?UserProjection;
}
