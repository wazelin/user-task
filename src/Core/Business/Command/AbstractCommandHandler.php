<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Business\Command;

use Broadway\CommandHandling\CommandHandler;

/**
 * @method __invoke(mixed $command): void
 */
abstract class AbstractCommandHandler implements CommandHandler
{
    public function handle(mixed $command): void
    {
        if (static::class !== $command::class . 'Handler') {
            return;
        }

        $this($command);
    }
}
