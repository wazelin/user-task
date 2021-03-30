<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Traits;

use Broadway\Domain\DomainMessage;

trait ProjectorTrait
{
    public function __invoke(DomainMessage $domainMessage): void
    {
        $this->handle($domainMessage);
    }

    abstract public function handle(DomainMessage $domainMessage): void;
}
