<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Business\Service;

use Broadway\UuidGenerator\UuidGeneratorInterface;
use Wazelin\UserTask\Core\Business\Domain\Id;

class IdGeneratorService
{
    public function __construct(private UuidGeneratorInterface $generator)
    {
    }

    public function generate(): Id
    {
        return new Id(
            $this->generator->generate()
        );
    }
}
