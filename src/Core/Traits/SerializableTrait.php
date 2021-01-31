<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Traits;

use Broadway\Serializer\Serializable;
use Stringable;

trait SerializableTrait
{
    public function serialize(): array
    {
        return array_map(
            function (string $property): mixed {
                $value = $this->$property;

                return match(true) {
                    $value instanceof Serializable => $value->serialize(),
                    $value instanceof Stringable => (string)$value,
                    default => $value
                };
            },
            static::getProperties()
        );
    }

    public static function deserialize(array $data): self
    {
        return new self(...$data);
    }

    abstract protected static function getProperties(): array;
}
