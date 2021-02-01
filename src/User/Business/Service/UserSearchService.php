<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Service;

use Wazelin\UserTask\Core\Contract\Exception\EntityNotFoundException;
use Wazelin\UserTask\User\Business\Contract\UserSearchQueryInterface;
use Wazelin\UserTask\User\Business\Domain\User;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class UserSearchService
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function findOneOrFail(UserSearchQueryInterface $query): User
    {
        $users = $this->find($query);

        if (!$users) {
            throw EntityNotFoundException::create(User::class);
        }

        return reset($users);
    }

    /***
     * @param UserSearchQueryInterface $query
     * @return User[]
     */
    public function find(UserSearchQueryInterface $query): array
    {
        return $this->repository->find(
            $query->getSearchRequest()
        );
    }
}
