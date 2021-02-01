<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Query;

use Wazelin\UserTask\User\Business\Contract\UserSearchQueryInterface;
use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;

class GetUsersQuery implements UserSearchQueryInterface
{
    public function __construct(private ?string $id = null, private ?string $name = null)
    {
    }

    public function getSearchRequest(): UserSearchRequest
    {
        $searchRequest = new UserSearchRequest();

        if (isset($this->id)) {
            $searchRequest->setId($this->id);
        }

        if (isset($this->name)) {
            $searchRequest->setName($this->name);
        }

        return $searchRequest;
    }
}
