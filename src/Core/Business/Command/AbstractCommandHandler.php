<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Business\Command;

use Broadway\CommandHandling\CommandHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * @method __invoke(mixed $command): void
 */
abstract class AbstractCommandHandler implements CommandHandler, MessageHandlerInterface
{
    public function handle(mixed $command): void
    {
        if (static::class !== $command::class . 'Handler') {
            return;
        }

        $this($command);
    }
}
