<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract;

interface IdentifiableSearchRequestInterface
{
    public function hasId();

    public function setId(string $id): static;

    public function getId(): string;

    public function hasIdOnly(): bool;

    public function isEmpty(): bool;
}
