<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Traits;

use Broadway\Serializer\Serializable;
use Stringable;

trait SerializableTrait
{
    public function serialize(): array
    {
        $data = [];

        foreach (static::getProperties() as $property) {
            $value = $this->$property;

            $data[$property] = match(true) {
                $value instanceof Serializable => $value->serialize(),
                $value instanceof Stringable => (string)$value,
                default => $value
            };
        }

        return $data;
    }

    abstract protected static function getProperties(): array;
}
