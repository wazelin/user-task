<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Tests;

trait WaitTrait
{
    public function wait(float $seconds): void
    {
        usleep((int)round($seconds * 1000000));
    }
}
