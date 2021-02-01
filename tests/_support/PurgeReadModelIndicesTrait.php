<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

trait PurgeReadModelIndicesTrait
{
    public function purgeReadModelIndices(): void
    {
        $this->runSymfonyConsoleCommand('core:persistence:read-model:create-indices');
    }
}
