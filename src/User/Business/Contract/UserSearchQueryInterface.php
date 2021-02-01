<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Contract;

use Wazelin\UserTask\User\Business\Domain\UserSearchRequest;

interface UserSearchQueryInterface
{
    public function getSearchRequest(): UserSearchRequest;
}
