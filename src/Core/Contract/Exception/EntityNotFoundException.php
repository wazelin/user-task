<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

class EntityNotFoundException extends RuntimeException
{
    #[Pure] public static function create(string $entity): self
    {
        return new static("$entity not found.");
    }
}
