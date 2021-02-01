<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract\Exception;

use RuntimeException;

class EntityNotFoundException extends RuntimeException
{
    public static function create(string $entity): self
    {
        return new static("$entity not found.");
    }
}
