<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Query;

use Wazelin\UserTask\User\Business\Contract\UserSearchQueryInterface;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;

class GetUserQuery implements UserSearchQueryInterface
{
    public function __construct(private string $id)
    {
    }

    public function getSearchRequest(): UserSearchRequest
    {
        return (new UserSearchRequest())
            ->setId($this->id);
    }
}
