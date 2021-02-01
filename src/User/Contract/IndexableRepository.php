<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Contract;

interface IndexableRepository
{
    public function createIndices(): bool;

    public function dropIndices(): bool;
}
