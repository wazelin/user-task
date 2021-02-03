<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

trait PurgeProjectionIndicesTrait
{
    public function purgeReadModelIndices(): void
    {
        $this->runSymfonyConsoleCommand('core:persistence:projection:create-indices');
    }
}
