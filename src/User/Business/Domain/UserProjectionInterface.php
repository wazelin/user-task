<?php

declare(strict_types=1);

namespace Wazelin\UserTask\User\Business\Domain;

use Broadway\ReadModel\Identifiable;

interface UserProjectionInterface extends Identifiable
{
    public function getName(): string;
}
