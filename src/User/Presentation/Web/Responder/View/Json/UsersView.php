<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\User\Business\Domain\UserProjection;

class UsersView implements JsonSerializable
{
    private array $users;

    public function __construct(UserProjection ...$users)
    {
        $this->users = $users;
    }

    public function jsonSerialize()
    {
        return array_map(
            static fn(UserProjection $user): UserView => new UserView($user),
            $this->users
        );
    }
}
