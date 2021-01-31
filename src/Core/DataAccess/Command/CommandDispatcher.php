<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\DataAccess\Command;

use Broadway\CommandHandling\CommandBus;

class CommandDispatcher
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function dispatch(mixed $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
