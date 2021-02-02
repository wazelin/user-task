<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Task\Business\Domain;

use InvalidArgumentException;

final class TaskStatus
{
    public const VALUES = [
        self::OPEN,
        self::TODO,
        self::DONE,
    ];

    private const OPEN = 'open';
    private const TODO = 'todo';
    private const DONE = 'done';

    public static function open(): self
    {
        return new self(self::OPEN);
    }

    public static function todo(): self
    {
        return new self(self::TODO);
    }

    public static function done(): self
    {
        return new self(self::DONE);
    }

    public static function fromString(string $value): self
    {
        if (!in_array($value, self::VALUES, true)) {
            throw new InvalidArgumentException("$value is an unknown " . self::class);
        }

        return new self($value);
    }

    public function __construct(private string $value)
    {
    }

    public function equals(self $status): bool
    {
        return (string)$this === (string)$status;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
