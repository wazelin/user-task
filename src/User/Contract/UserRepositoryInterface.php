<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Contract;

use Wazelin\UserTask\User\Business\Domain\ReadModel\User;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;

interface UserRepositoryInterface
{
    public function persist(User $user);

    /**
     * @param UserSearchRequest $searchRequest
     * @return User[]
     */
    public function find(UserSearchRequest $searchRequest): array;

    public function findOneById(string $id): ?User;
}
