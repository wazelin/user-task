<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Projector;

use Broadway\ReadModel\Projector;
use Wazelin\UserTask\User\Business\Domain\User;
use Wazelin\UserTask\User\Business\Domain\UserEvent\UserWasCreatedEvent;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class UserProjector extends Projector
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    protected function applyUserWasCreatedEvent(UserWasCreatedEvent $event): void
    {
        $this->repository->persist(
            (new User())->applyUserWasCreatedEvent($event)
        );
    }
}
