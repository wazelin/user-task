<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Presentation\Web\Responder\View\Json;

use JsonSerializable;
use Wazelin\UserTask\User\Business\Domain\UserProjectionInterface;

class PureUserView implements JsonSerializable
{
    public function __construct(private UserProjectionInterface $user)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->user->getId(),
            'name' => $this->user->getName(),
        ];
    }
}
