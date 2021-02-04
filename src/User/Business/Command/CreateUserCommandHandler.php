<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Command;

use Broadway\EventSourcing\EventSourcingRepository;
use Wazelin\UserTask\Core\Business\Command\AbstractCommandHandler;
use Wazelin\UserTask\User\Business\Domain\User;

final class CreateUserCommandHandler extends AbstractCommandHandler
{
    public function __construct(private EventSourcingRepository $userRepository)
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $this->userRepository->save(
            User::create(
                $command->getId(),
                $command->getName()
            )
        );
    }
}
