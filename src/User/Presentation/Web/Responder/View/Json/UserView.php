<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\User\Business\Domain\User;

class UserView implements JsonSerializable
{
    public function __construct(private User $user)
    {
    }

    public function jsonSerialize(): array
    {
        return $this->user->serialize();
    }
}
