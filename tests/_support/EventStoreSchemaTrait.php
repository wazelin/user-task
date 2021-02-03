<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

trait EventStoreSchemaTrait
{
    public function createEventStore(): void
    {
        $this->runSymfonyConsoleCommand('core:persistence:event-store:create');
    }
    public function dropEventStore(): void
    {
        $this->runSymfonyConsoleCommand('core:persistence:event-store:drop');
    }
}
