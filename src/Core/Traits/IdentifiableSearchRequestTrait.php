<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Traits;

use JetBrains\PhpStorm\Pure;

trait IdentifiableSearchRequestTrait
{
    private ?string $id = null;

    public function hasId(): bool
    {
        return null !== $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    #[Pure] public function hasIdOnly(): bool
    {
        $properties = $this->getProperties();

        return count($properties) === 1 && isset($properties['id']);
    }

    #[Pure] public function isEmpty(): bool
    {
        return !$this->getProperties();
    }

    protected function getProperties(): array
    {
        return array_filter(
            get_object_vars($this)
        );
    }
}
