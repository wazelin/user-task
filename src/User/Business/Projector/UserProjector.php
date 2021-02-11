<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Projector;

use Broadway\ReadModel\Projector;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Wazelin\UserTask\Core\Traits\ProjectorTrait;
use Wazelin\UserTask\User\Business\Domain\Event\UserWasCreatedEvent;
use Wazelin\UserTask\User\Business\Domain\UserProjection;
use Wazelin\UserTask\User\Contract\UserRepositoryInterface;

class UserProjector extends Projector implements MessageHandlerInterface
{
    use ProjectorTrait;

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    protected function applyUserWasCreatedEvent(UserWasCreatedEvent $event): void
    {
        $this->repository->persist(
            new UserProjection(
                (string)$event->getId(),
                $event->getName()
            )
        );
    }
}
