<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

trait ReplayEventsTrait
{
    public function replayEvents(): void
    {
        $this->runSymfonyConsoleCommand('core:persistence:event-store:replay');
    }
}
