<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract;

interface IndexableRepositoryInterface
{
    public function createIndices(): bool;

    public function dropIndices(): bool;
}
