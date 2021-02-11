<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\DataAccess\Command;

use Symfony\Component\Messenger\MessageBusInterface;

class CommandDispatcher
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function dispatch(mixed $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
